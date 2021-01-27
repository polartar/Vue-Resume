<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use PDF;
use Str;

class GenerateResumePdfController extends Controller
{
    const WORK_EXPERIENCE_SECTION_HEADER_LINE_COUNT = 2;
    const WORK_EXPERIENCE_HEADER_LINE_COUNT = 2;

    const EDUCATION_SECTION_HEADER_LINE_COUNT = 2;
    const EDUCATION_HEADER_LINE_COUNT = 2;

    const SKILLS_SECTION_HEADER_LINE_COUNT = 2;
    const SKILLS_HEADER_LINE_COUNT = 2;

    const HOBBIES_SECTION_HEADER_LINE_COUNT = 2;
    const HOBBIES_HEADER_LINE_COUNT = 2;

    const FIRST_PAGE_LINE_LIMIT = 32;
    const AVERAGE_LINE_LENGTH = 80;

    public function __invoke(Request $request, Resume $resume)
    {

        $resume->load(['user', 'phone', 'resumeLinks', 'hobbies', 'resumeSkill', 'email', 'address', 'resumeSummaries', 'resumeEducations.educationDescriptions', 'resumeWorkExperiences.resumeDescriptions', 'resumeDesign']);
        /* Ideas for page breaks
            Lines have between 1 and 85 characters, with a common minimum being 80 characters

            New section headers use about 3 lines total
            This means that at the minimum, each work experience will add 4 lines

            We can have a total of 19 lines on the first page

            A count of the number of characters in each work/education description field / 80 should give us the number of lines

            Based on this information, we can keep a count of how many lines are taken, and if that exceeds the max bound,
                then we know where to put a page break. We then reset the count and continue on until the PDF is rendered.

            I'm thinking an array of indexes (work experiences AND educations) and after each index listed we put a page break
        */
        $workExperienceSectionBreak = false;
        $workExperienceIndexBreaks = [];

        $educationSectionBreak = false;
        $educationIndexBreaks = [];

        $skillSectionBreak = false;
        $skillIndexBreaks = [];

        $hobbySectionBreak = false;
        $hobbyIndexBreaks = [];

        $lineCount = 2;


        /* Summary line count
            If the summary is in the bullet point format, create an array by exploding the newlines
            Assuming here that the user won't blow out the entire first page with the summary section (10/29/20)
        */
        if (count($resume->resumeSummaries) > 0) {
            $resumeSummary = $resume->resumeSummaries[0];

            if ($resumeSummary->bullet_point) {
                $names = explode("\n", $resumeSummary->name);
            } else {
                $names = [$resumeSummary->name];
            }

            /* Each line is worth 1, so we want to round up.
                If $name ends up being 1.1 lines (88 chars), then 2 lines need to be allocated
            */
            foreach ($names as $name) {
                $lineCount += round( strlen($name) / self::AVERAGE_LINE_LENGTH);
            }
        }

        /* Work Experience Section
            Counting the headers and the description lines
        */
        if ($lineCount + self::WORK_EXPERIENCE_SECTION_HEADER_LINE_COUNT >= self::FIRST_PAGE_LINE_LIMIT) {
            $lineCount = self::WORK_EXPERIENCE_HEADER_LINE_COUNT;
            $workExperienceSectionBreak = true;
        } else {
            $lineCount += self::WORK_EXPERIENCE_SECTION_HEADER_LINE_COUNT;
        }


        /* Check what the line count will be with each work experience
            If it exceeds FIRST_PAGE_LINE_LIMIT, then the index of that work experience will be noted.
        */
        foreach ($resume->resumeWorkExperiences as $key=>$workExperience) {
            $lines = self::WORK_EXPERIENCE_HEADER_LINE_COUNT;

            if ( count($workExperience->resumeDescriptions) > 0 ) {
                $lines += round( strlen($workExperience->resumeDescriptions[0]->description) / self::AVERAGE_LINE_LENGTH );
                $lines += count(preg_split('/\n+/', $workExperience->resumeDescriptions));
            }

            if ($lineCount + $lines >= self::FIRST_PAGE_LINE_LIMIT) {
                $lineCount = $lines;
                array_push($workExperienceIndexBreaks, $key);
            } else {
                $lineCount += $lines;
            }
        }


        /* Education Section
            Counting the headers and description lines
        */
        if ($lineCount + self::EDUCATION_SECTION_HEADER_LINE_COUNT >= self::FIRST_PAGE_LINE_LIMIT) {
            $lineCount = self::EDUCATION_SECTION_HEADER_LINE_COUNT;
            $educationSectionBreak = true;
        } else {
            $lineCount += self::EDUCATION_SECTION_HEADER_LINE_COUNT;
        }


        /* Check what the line count will be with each education
            If it exceeds FIRST_PAGE_LINE_LIMIT, then the index of that education will be noted.
        */
        foreach ($resume->resumeEducations as $key=>$education) {
            $lines = self::EDUCATION_HEADER_LINE_COUNT;

            if ( count($education->educationDescriptions) > 0 ) {
                $lines += round( strlen($education->educationDescriptions[0]->description) / self::AVERAGE_LINE_LENGTH );
            }

            if ($lineCount + $lines >= self::FIRST_PAGE_LINE_LIMIT) {
                $lineCount = $lines;
                array_push($educationIndexBreaks, $key);
            } else {
                $lineCount += $lines;
            }
        }

        /* Skills Section
            Counting the headers and description lines
        */
        if ($lineCount + self::SKILLS_SECTION_HEADER_LINE_COUNT >= self::FIRST_PAGE_LINE_LIMIT) {
            $lineCount = self::SKILLS_SECTION_HEADER_LINE_COUNT;
            $skillSectionBreak = true;
        } else {
            $lineCount += self::SKILLS_SECTION_HEADER_LINE_COUNT;
        }


        /* Check what the line count will be with each skills
            If it exceeds FIRST_PAGE_LINE_LIMIT, then the index of that skill will be noted.
        */
        foreach ($resume->resumeSkill as $key=>$skill) {
            $lines = self::SKILLS_HEADER_LINE_COUNT;

            $lines += round( strlen($skill->name) / self::AVERAGE_LINE_LENGTH );

            if ($lineCount + $lines >= self::FIRST_PAGE_LINE_LIMIT) {
                $lineCount = $lines / 4;
                array_push($skillIndexBreaks, $key);
            } else {
                $lineCount += $lines / 4;
            }
        }

        /* Hobbies Section
            Counting the headers and description lines
        */
        if ($lineCount + self::HOBBIES_SECTION_HEADER_LINE_COUNT >= self::FIRST_PAGE_LINE_LIMIT) {
            $lineCount = self::HOBBIES_SECTION_HEADER_LINE_COUNT;
            $hobbySectionBreak = true;
        } else {
            $lineCount += self::HOBBIES_SECTION_HEADER_LINE_COUNT;
        }


        /* Check what the line count will be with each skills
            If it exceeds FIRST_PAGE_LINE_LIMIT, then the index of that hobby will be noted.
        */
        foreach ($resume->hobbies as $key => $hobby) {
            $lines = self::HOBBIES_HEADER_LINE_COUNT;

            $lines += round( strlen($hobby->name) / self::AVERAGE_LINE_LENGTH );

            if ($lineCount + $lines >= self::FIRST_PAGE_LINE_LIMIT) {
                $lineCount = $lines / 2;
                array_push($hobbyIndexBreaks, $key);
            } else {
                $lineCount += $lines / 2;
            }
        }




        /* Generating the PDF */

        if($resume->resumeDesign) {
            $template = Str::slug($resume->resumeDesign->name, '-');

            $date_formats = [
                1 => 'F Y',
                2 => 'j/n/Y',
                3 => 'j-n-Y',
                4 => 'n/j/Y',
                5 => 'n-j-Y',
                6 => 'n/Y',
                7 => 'n-Y',
            ];

            $date_format = $date_formats[$resume->date_format];

            // dd($resume);

            $pdf = PDF::loadView('templates.' . $template, compact([
                'resume',
                'workExperienceSectionBreak',
                'workExperienceIndexBreaks',
                'educationSectionBreak',
                'educationIndexBreaks',
                'date_format',
                'skillSectionBreak',
                'skillIndexBreaks',
                'hobbySectionBreak',
            ]));


            if ($request->get('page')) {
                return view('templates.' . $template, compact([
                    'resume',
                    'workExperienceSectionBreak',
                    'workExperienceIndexBreaks',
                    'educationSectionBreak',
                    'educationIndexBreaks',
                    'date_format',
                    'skillSectionBreak',
                    'skillIndexBreaks',
                    'hobbySectionBreak',
                ]));
            }
            $pdf->setPaper('letter', 'portrait');

            if ($request->get('preview')) {
                return $pdf->stream();
            }

            return $pdf->download('resume.pdf');
        }
    }
}
