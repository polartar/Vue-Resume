<template>
    <div>

        <div class="resume-step-heading-container">
            <h3 class="resume-step-heading">Skills</h3>
        </div>

        <div class="resume-step-form">
            <div class="grid-x grid-margin-x">
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="">
                    </div>
                </div>
            </div>
        </div>
        <button class="button" @click="$router.go(-1)" style="background-color: grey!important;">Back</button>
        <router-link tag="button" class="button" to="customize-design">Save and Next</router-link>
    </div>
</template>
<script>
    export default {}
</script>
