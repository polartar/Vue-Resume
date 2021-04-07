<template>
  <div v-loading="isSaving">
    <div class="resume-step-heading-container">
      <h3 class="resume-step-heading">Contact Information</h3>
    </div>
    <div class="resume-step-form">
      <div class="grid-x grid-margin-x">
        <div class="cell medium-6">
          <div class="form-group">
            <label>First Name*</label>
            <input
              required
              type="text"
              name="first_name"
              :value="firstName"
              @input="updateFirstName"
            />
          </div>
        </div>
        <div class="cell medium-6">
          <div class="form-group">
            <label>Last Name*</label>
            <input
              required
              type="text"
              name="last_name"
              :value="lastName"
              @input="updateLastName"
            />
          </div>
        </div>
        <div class="cell medium-6">
          <!-- make select with saved emails and option to add new -->
          <div class="form-group">
            <label>Email*</label>
            <input
              required
              type="email"
              name="email"
              :value="resume.email"
              @input="updateResumeEmail"
            />
          </div>
        </div>
        <div class="cell medium-6">
          <div class="form-group">
 
            <label>Phone*</label>
            <input
              required
              type="tel"
              name="phone"
              :value="phone"
              @input="updatePhone"
            />
          </div>
        </div>
        <div class="cell">
          <div class="form-group">
            <label>LinkedIn URL*</label>
            <input
              required
              type="url"
              name="linkedin_url"
              :value="resume.linkedin_url"
              @input="updateLinkedInUrl"
            />
          </div>
        </div>
      </div>
    </div>

    <div class="resume-step-heading-container">
      <h3 class="resume-step-heading">My Address</h3>
    </div>

    <div class="resume-step-form">
      <div class="grid-x grid-margin-x">
        <div class="cell">
          <div class="form-group">
            <label>Country*</label>
            <div class="fancy-select fancy-select-full-width">
              <font-awesome-icon
                aria-hidden="true"
                class="fancy-select-icon"
                :icon="['fas', 'caret-down']"
              ></font-awesome-icon>
              <select
                required
                class="fancy-select"
                :value="country"
                name="country"
                @change="updateCountry"
              >
                <!-- #region(collapsed) Countries -->
                <option value="" selected disabled
                  >--- Choose a country ---</option
                >
                <option v-for="country in countries" v-bind:key="'id_' + country.name" :disabled="country.name==='disabled'? true: false" >
                  {{country.name ==='disabled'? '----': country.name}}
                </option>
                <!-- #endregion -->
              </select>
            </div>
          </div>
        </div>
        <div class="cell">
          <div class="form-group">
            <label
              >Street 1
              <span class="label-optional-text">(Optional)</span></label
            >
            <input
              type="text"
              name="street_1"
              :value="street_1"
              @input="updateStreet1"
            />
          </div>
        </div>
        <div class="cell">
          <div class="form-group">
            <label
              >Street 2
              <span class="label-optional-text">(Optional)</span></label
            >
            <input
              type="text"
              name="street_2"
              :value="street_2"
              @input="updateStreet2"
            />
          </div>
        </div>
        <div class="cell medium-6">
          <div class="form-group">
            <label>City*</label>
            <input
              required
              type="text"
              name="city"
              :value="city"
              @input="updateCity"
            />
          </div>
        </div>
        <div class="cell medium-6">
          <div class="form-group">
            <label
              >State*<span v-if="country != 'United States'">
                / Province</span
              ></label
            >
            <div
              class="fancy-select fancy-select-full-width"
              v-if="country == 'United States'"
            >
              <font-awesome-icon
                aria-hidden="true"
                class="fancy-select-icon"
                :icon="['fas', 'caret-down']"
              ></font-awesome-icon>
              <select
                required
                class="fancy-select"
                :value="province?province:'default'"
                name="province"
                @change="updateProvince"
              >
                <!-- #region(collapsed) States -->
                <option value="default">Select State</option>
                <option
                  v-for="state in states"
                  :key="state.name"
                  :value="state.name"
                >
                  {{ state.value }}
                </option>
                <!-- #endregion -->
              </select>
            </div>
            <div v-else>
              <input required type="text" name="province" :value='province'  @input="updateProvince"/>
            </div>
          </div>
        </div>
        <div class="cell medium-6">
          <div class="form-group">
            <label
              ><span v-if="country == 'United States'">Zip</span
              ><span v-else>Postal</span> Code
              <span class="label-optional-text">(Optional)</span></label
            >
            <input
              type="text"
              name="postal_code"
              :value="zip"
              @input="updateZip"
            />
          </div>
        </div>
      </div>
    </div>
    <div class="resume-form-nav-buttons">
      <button class="button back-button" @click="$router.go(-1)">
        <font-awesome-icon
          aria-hidden="true"
          class="fancy-select-icon"
          :icon="['fas', 'arrow-left']"
        ></font-awesome-icon>
      </button>
      <button class="button preview-button" @click="updateToggleResumePreview">
        <span v-if="toggleResumePreview">Stop </span>Preview
      </button>
      <button class="button" @click="saveContactInfo">
        Save &amp; Continue
      </button>
      <!-- <router-link tag="button" class="button" v-on:click.native="saveContactInfo" to="resume-summary">Save &amp; Continue</router-link> -->
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex';
import { states, countries } from '../../constants/contact';
import { Notification } from 'element-ui';

export default {
  data() {
    return {
      newPhone: '',
      states,
      countries,
      isSaving: false
    };
  },
 
  computed: {
    ...mapState([
      'resume',
      "email",
      'firstName',
      'lastName',
      'phone',
      'street_1',
      'street_2',
      'city',
      'province',
      'country',
      'zip',
      'userEmailIds',
      'userAddressIds',
      'userPhoneIds',
      'toggleResumePreview',
      'refreshPreview',
    ]),
  },
  mounted() {
  },
  methods: {
    ...mapMutations(['updateFirstName', 'updateLastName']),
    updateFirstName: function(event) {
      this.$store.commit('updateFirstName', event.target.value);
    },
    updateLastName: function(event) {
      this.$store.commit('updateLastName', event.target.value);
    },
    updatePhone: function(event) {
      this.$store.commit('updatePhone', event.target.value);
    },
    updateCountry: function(event) {
      this.$store.commit('updateProvince', "");
      this.$store.commit('updateCountry', event.target.value);
    },
    updateStreet1: function(event) {
      this.$store.commit('updateStreet1', event.target.value);
    },
    updateStreet2: function(event) {
      this.$store.commit('updateStreet2', event.target.value);
    },
    updateCity: function(event) {
      this.$store.commit('updateCity', event.target.value);
    },
    updateProvince: function(event) {
       if(typeof(event.target.options) === 'object'){
        this.$store.commit('updateProvince', event.target.options[event.target.options.selectedIndex].value);
      }
      else
        this.$store.commit('updateProvince', event.target.value);
    },
    updateZip: function(event) {
      this.$store.commit('updateZip', event.target.value);
    },
    updateToggleResumePreview: function(event) {
      this.$store.commit(
        'updateToggleResumePreview',
        !this.toggleResumePreview,
      );
    },
    updateRefreshPreview: function(event) {
      this.$store.commit('updateRefreshPreview');
    },
    updateResumeEmail: function(event) {
      this.$store.commit('updateResumeEmail', event.target.value);
    },
    updateLinkedInUrl: function(event) {
      this.$store.commit('updateLinkedInUrl', event.target.value);
    },

    saveContactInfo: async function() {
       if (
        !this.firstName ||
        !this.lastName ||
        !this.resume.email ||
        !this.phone ||
        !this.resume.linkedin_url ||
        !this.country ||
        this.province === 'default' ||
        !this.province ||
        !this.city
      ) {
        this.showMessage("error", "You should input all required fields");
        return;
      }
      if(this.phone.length < 10)
      {
        this.showMessage("error", "Phone number is invalid");
        return;
      }
      if(!this.validateEmail(this.resume.email)){
        this.showMessage("error", "Email is invalid");
        return;
      }

      if(!this.isValidatedURL(this.resume.linkedin_url)){
        this.showMessage("error", "LinkedinURL is invalid");
        return;
      }

      this.isSaving = true;
      // Update User Info
      // let updatedUser = this.$store.state.resume.user;
      // updatedUser.first_name = this.firstName;
      // updatedUser.last_name = this.lastName;

      // const success = await this.$store.dispatch('axiosPutRequest', {
      //   route: '/update-user/' + updatedUser.id,
      //   payload: updatedUser,
      //   commits: [],
      // });
      const success = await this.$store.dispatch('axiosPutRequest', {
                    route: '/resume/' + this.resume.id,
                    payload: this.resume,
                });

      const success1 = await this.createUserPhone();
      const success2 = await this.createUserEmail();
      const success3 = await this.createUserAddress(true);

      let success4 = true;
      if (this.resume.linkedin_url) {
        success4 = await this.createLinkedInURL();
      }

      // await this.updateRefreshPreview();

      if (success && success1 && success2 && success3 && success4){
        const res  = await this.saveResume();
        if(res)
          this.$router.push({ name: 'resume-summary', query: this.$route.query });
      }
      // await this.updateRefreshPreview();
      this.isSaving = false;
    },
    createUserPhone: async function() {
      let phone = await this.$store.dispatch('axiosPostRequest', {
        route: '/user-phone',
        payload: {
          user_id: this.resume.user.id,
          phone_number: this.phone,
          resume_id: this.resume.id,
        },
        successMessage: null,
        commits: ['addResumePhoneId'],
      });

      return phone;
    },
    showMessage(type, message){
        if(type ==="success"){
            Notification.success({
                title: 'Success',
                message: message,
            });
        } else{
             Notification.error({
                title: 'Error',
                message: message,
            });
        }
    },
    validateEmail(email){
        const mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if(mailformat.test(email))
            return true
        else return false;
    },
    createUserEmail: async function() {
      let email = await this.$store.dispatch('axiosPostRequest', {
        route: '/user-email',
        payload: {
          user_id: this.resume.user.id,
          email: this.resume.email,
          resume_id: this.resume.id,
        },
        successMessage: null,
        commits: ['addUserEmailId'],
      });

      return email;
    },
    createUserAddress: async function() {
      let address = await this.$store.dispatch('axiosPostRequest', {
        route: '/user-address',
        payload: {
          user_id: this.resume.user.id,
          street_1: this.street_1,
          street_2: this.street_2,
          city: this.city,
          province: this.province,
          country: this.country,
          postal_code: this.zip,
          resume_id: this.resume.id,
        },
        successMessage: null,
        commits: ['addUserAddressId'],
      });

      return address;
    },
    createLinkedInURL: async function() {
      let linkedin_url = await this.$store.dispatch('axiosPostRequest', {
        route: '/resume-links',
        payload: {
          url: this.resume.linkedin_url,
          name: 'LinkedIn',
          resume_id: this.resume.id,
        },
        successMessage: null,
      });

      return linkedin_url;
    },
    saveResume: async function() {
      // Eager loading needs a little love on the way back
      let updateData = this.resume;
      updateData['user_id'] = this.resume.user.id;
      updateData['user_email_id'] = this.$store.state.userEmailIds;
      updateData['user_address_id'] = this.$store.state.userAddressIds;
      updateData['user_phone_id'] = this.$store.state.userPhoneIds;

      const success = await this.$store.dispatch('axiosPutRequest', {
        route: '/resume/' + this.resume.id,
        payload: updateData,
        successMessage: 'Successfully saved contact information',
      });

      return success;
    },
    isValidatedURL(url){
      var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
        '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
      return !!pattern.test(url);
    }
  },
};
</script>
