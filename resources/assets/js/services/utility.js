
import moment from "moment"

export const convertDate = (date, type)=>{
    const formats = ['MMMM YYYY', 'D/M/YYYY', 'D-M-YYYY','M/D/YYYY', 'M-D-YYYY', 'M/YYYY','M-YYYY'];
    return moment(date).format(formats[type-1]);
}

