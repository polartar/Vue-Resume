<template>
    <div>
        <div class="resume-step-heading-container">
            <h3 class="resume-step-heading">Contact Information</h3>
        </div>

        <div class="resume-step-form">
            <div class="grid-x grid-margin-x">
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>First Name</label>
                        <input required type="text" name="first_name" :value="firstName" @input="updateFirstName">
                    </div>
                </div>
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input required type="text" name="last_name" :value="lastName" @input="updateLastName">
                    </div>
                </div>
                <div class="cell medium-6">
                    <!-- make select with saved emails and option to add new -->
                    <div class="form-group">
                        <label>Email</label>
                        <input required type="email" name="email" :value="email" disabled>
                    </div>
                </div>
                <div class="cell medium-6">
                    <!-- make select with saved phones and option to add new -->
                    <div class="form-group">
                        <label>Phone</label>
                        <input required type="tel" name="phone" :value="phone" @input="updatePhone">
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
                        <label>Country</label>
                        <div class="fancy-select fancy-select-full-width">
                            <font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'caret-down']"></font-awesome-icon>
                            <select required class="fancy-select" :value="country" name="country" @change="updateCountry">
                                <!-- #region(collapsed) Countries -->
                                <option value="" selected disabled>--- Choose a country ---</option>
                                <option value="United States">United States</option>
                                <option value="Australia">Australia</option>
                                <option value="Canada">Canada</option>
                                <option value="Germany">Germany</option>
                                <option value="India">India</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option disabled value="">------</option>
                                <option value="Afghanistan">Afghanistan</option>
                                <option value="Åland">Åland</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                                <option value="American Samoa">American Samoa</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Anguilla">Anguilla</option>
                                <option value="Antarctica">Antarctica</option>
                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Aruba">Aruba</option>
                                <!-- <option value="Australia">Australia</option> -->
                                <option value="Austria">Austria</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Belize">Belize</option>
                                <option value="Benin">Benin</option>
                                <option value="Bermuda">Bermuda</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Bonaire">Bonaire</option>
                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Bouvet Island">Bouvet Island</option>
                                <option value="Brazil">Brazil</option>
                                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                <option value="British Virgin Islands">British Virgin Islands</option>
                                <option value="Brunei">Brunei</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Cameroon">Cameroon</option>
                                <!-- <option value="Canada">Canada</option> -->
                                <option value="Cape Verde">Cape Verde</option>
                                <option value="Cayman Islands">Cayman Islands</option>
                                <option value="Central African Republic">Central African Republic</option>
                                <option value="Chad">Chad</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Christmas Island">Christmas Island</option>
                                <option value="Cocos [Keeling] Islands">Cocos [Keeling] Islands</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Cook Islands">Cook Islands</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Curacao">Curacao</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Democratic Republic of the Congo">Democratic Republic of the Congo</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Djibouti">Djibouti</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Dominican Republic">Dominican Republic</option>
                                <option value="East Timor">East Timor</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egypt">Egypt</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Ethiopia">Ethiopia</option>
                                <option value="Falkland Islands">Falkland Islands</option>
                                <option value="Faroe Islands">Faroe Islands</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="French Guiana">French Guiana</option>
                                <option value="French Polynesia">French Polynesia</option>
                                <option value="French Southern Territories">French Southern Territories</option>
                                <option value="Gabon">Gabon</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Georgia">Georgia</option>
                                <!-- <option value="Germany">Germany</option> -->
                                <option value="Ghana">Ghana</option>
                                <option value="Gibraltar">Gibraltar</option>
                                <option value="Greece">Greece</option>
                                <option value="Greenland">Greenland</option>
                                <option value="Grenada">Grenada</option>
                                <option value="Guadeloupe">Guadeloupe</option>
                                <option value="Guam">Guam</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Guernsey">Guernsey</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                <option value="Guyana">Guyana</option>
                                <option value="Haiti">Haiti</option>
                                <option value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Hong Kong">Hong Kong</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <!-- <option value="India">India</option> -->
                                <option value="Indonesia">Indonesia</option>
                                <option value="Iran">Iran</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Isle of Man">Isle of Man</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Ivory Coast">Ivory Coast</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Japan">Japan</option>
                                <option value="Jersey">Jersey</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Kazakhstan">Kazakhstan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="Kosovo">Kosovo</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                <option value="Laos">Laos</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Lebanon">Lebanon</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libya">Libya</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Macao">Macao</option>
                                <option value="Macedonia">Macedonia</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mali">Mali</option>
                                <option value="Malta">Malta</option>
                                <option value="Marshall Islands">Marshall Islands</option>
                                <option value="Martinique">Martinique</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="Mauritius">Mauritius</option>
                                <option value="Mayotte">Mayotte</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Micronesia">Micronesia</option>
                                <option value="Moldova">Moldova</option>
                                <option value="Monaco">Monaco</option>
                                <option value="Mongolia">Mongolia</option>
                                <option value="Montenegro">Montenegro</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Morocco">Morocco</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Myanmar [Burma]">Myanmar [Burma]</option>
                                <option value="Namibia">Namibia</option>
                                <option value="Nauru">Nauru</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Netherlands">Netherlands</option>
                                <option value="New Caledonia">New Caledonia</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Niger">Niger</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Niue">Niue</option>
                                <option value="Norfolk Island">Norfolk Island</option>
                                <option value="North Korea">North Korea</option>
                                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                <option value="Norway">Norway</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Palau">Palau</option>
                                <option value="Palestine">Palestine</option>
                                <option value="Panama">Panama</option>
                                <option value="Papua New Guinea">Papua New Guinea</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Peru">Peru</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Pitcairn Islands">Pitcairn Islands</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Puerto Rico">Puerto Rico</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Republic of the Congo">Republic of the Congo</option>
                                <option value="Réunion">Réunion</option>
                                <option value="Romania">Romania</option>
                                <option value="Russia">Russia</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="Saint Barthélemy">Saint Barthélemy</option>
                                <option value="Saint Helena">Saint Helena</option>
                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                <option value="Saint Lucia">Saint Lucia</option>
                                <option value="Saint Martin">Saint Martin</option>
                                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                <option value="Samoa">Samoa</option>
                                <option value="San Marino">San Marino</option>
                                <option value="São Tomé and Príncipe">São Tomé and Príncipe</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Sierra Leone">Sierra Leone</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Sint Maarten">Sint Maarten</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Solomon Islands">Solomon Islands</option>
                                <option value="Somalia">Somalia</option>
                                <option value="South Africa">South Africa</option>
                                <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                                <option value="South Korea">South Korea</option>
                                <option value="South Sudan">South Sudan</option>
                                <option value="Spain">Spain</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Sudan">Sudan</option>
                                <option value="Suriname">Suriname</option>
                                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                <option value="Swaziland">Swaziland</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Syria">Syria</option>
                                <option value="Taiwan">Taiwan</option>
                                <option value="Tajikistan">Tajikistan</option>
                                <option value="Tanzania">Tanzania</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Togo">Togo</option>
                                <option value="Tokelau">Tokelau</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="U.S. Minor Outlying Islands">U.S. Minor Outlying Islands</option>
                                <option value="U.S. Virgin Islands">U.S. Virgin Islands</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <!-- <option value="United Kingdom">United Kingdom</option> -->
                                <option value="Uruguay">Uruguay</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Vatican City">Vatican City</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Vietnam">Vietnam</option>
                                <option value="Wallis and Futuna">Wallis and Futuna</option>
                                <option value="Western Sahara">Western Sahara</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                                <!-- #endregion -->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="cell">
                    <div class="form-group">
                        <label>Street 1 <span class="label-optional-text">(Optional)</span></label>
                        <input type="text" name="street_1" :value="street_1" @input="updateStreet1">
                    </div>
                </div>
                <div class="cell">
                    <div class="form-group">
                        <label>Street 2 <span class="label-optional-text">(Optional)</span></label>
                        <input type="text" name="street_2" :value="street_2" @input="updateStreet2">
                    </div>
                </div>
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>City</label>
                        <input required type="text" name="city" :value="city" @input="updateCity">
                    </div>
                </div>
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>State<span v-if="country != 'United States'"> / Province</span></label>
                        <div class="fancy-select fancy-select-full-width" v-if="country == 'United States'">
                            <font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'caret-down']"></font-awesome-icon>
                            <select required class="fancy-select" :value="province" name="province" @input="updateProvince">
                                <!-- #region(collapsed) States -->
                                <option value="">Select State</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">District of Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="MA">Massachusetts</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                                <!-- #endregion -->
                            </select>
                        </div>
                        <div v-else>
                            <input required type="text" name="province" value="">
                        </div>
                    </div>
                </div>
                <div class="cell medium-6">
                    <div class="form-group">
                        <label><span v-if="country == 'United States'">Zip</span><span v-else>Postal</span> Code <span class="label-optional-text">(Optional)</span></label>
                        <input type="text" name="postal_code" :value="zip" @input="updateZip">
                    </div>
                </div>
            </div>
        </div>
        <div class="resume-form-nav-buttons">
            <button class="button back-button" @click="$router.go(-1)"><font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'arrow-left']"></font-awesome-icon></button>
            <button class="button preview-button" @click="updateToggleResumePreview"><span v-if="toggleResumePreview">Stop </span>Preview</button>
            <router-link tag="button" class="button" v-on:click.native="saveContactInfo" to="resume-summary">Save &amp; Continue</router-link>
        </div>
    </div>

</template>

<script>
    import { mapState, mapMutations } from 'vuex'

    export default {

        computed: mapState([
            'resume',
            'firstName',
            'lastName',
            'email',
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
        methods: {
            ...mapMutations([
                'updateFirstName',
                'updateLastName',
            ]),
            updateFirstName: function(event) {
                this.$store.commit('updateFirstName', event.target.value)
            },
            updateLastName: function(event) {
                this.$store.commit('updateLastName', event.target.value)
            },
            updatePhone: function (event) {
                this.$store.commit('updatePhone', event.target.value);
            },
            updateCountry: function (event) {
                this.$store.commit('updateCountry', event.target.value);
            },
            updateStreet1: function (event) {
                this.$store.commit('updateStreet1', event.target.value);
            },
            updateStreet2: function (event) {
                this.$store.commit('updateStreet2', event.target.value);
            },
            updateCity: function (event) {
                this.$store.commit('updateCity', event.target.value);
            },
            updateProvince: function (event) {
                this.$store.commit('updateProvince', event.target.value);
            },
            updateZip: function (event) {
                this.$store.commit('updateZip', event.target.value);
            },
            updateToggleResumePreview: function (event) {
                this.$store.commit('updateToggleResumePreview', !this.toggleResumePreview)
            },
            updateRefreshPreview: function (event) {
                this.$store.commit('updateRefreshPreview')
            },


            saveContactInfo: async function () {
                // Update User Info
                let updatedUser = this.$store.state.resume.user;
                updatedUser.first_name = this.firstName;
                updatedUser.last_name = this.lastName;
                this.$store.dispatch('axiosPutRequest', {
                    route: '/update-user/' + updatedUser.id,
                    payload: updatedUser,
                    successMessage: 'You updated your name!', // TODO: Remove this notification
                    commits: [],
                });

                /*
                    No updating the email address, this is a bad idea.
                    TODO: Add an email field to the resume, so that the user can display a different email if they want.
                */

                // Need to create a userPhone, then add it to the list of ids
                await this.createUserPhone();

                // Need to create a userEmail
                await this.createUserEmail();

                // Need to create a userAddress
                await this.createUserAddress(true);

                await this.updateRefreshPreview()
                // Update resume via post w/all info (probably going to create new address)
                //this.saveResume();
            },
            createUserPhone: async function () {
                await this.$store.dispatch('axiosPostRequest', {
                    route: '/user-phone',
                    payload: {
                        'user_id': this.resume.user.id,
                        'phone_number': this.phone
                    },
                    successMessage: null,
                    commits: ['addUserPhoneId'],
                });
            },
            createUserEmail: async function () {
                await this.$store.dispatch('axiosPostRequest', {
                    route: '/user-email',
                    payload: {
                        'user_id': this.resume.user.id,
                        'email': this.email
                    },
                    successMessage: null,
                    commits: ['addUserEmailId'],
                });
            },
            createUserAddress: async function (saveResume = false) {
                await this.$store.dispatch('axiosPostRequest', {
                    route: '/user-address',
                    payload: {
                        'user_id': this.resume.user.id,
                        'street_1': this.street_1,
                        'street_2': this.street_2,
                        'city': this.city,
                        'province': this.province,
                        'country': this.country,
                        'postal_code': this.zip,
                    },
                    successMessage: null,
                    commits: ['addUserAddressId'],
                });

                if (saveResume)
                    await this.saveResume();
            },

            saveResume: async function () {
                // Eager loading needs a little love on the way back
                let updateData = this.resume;
                updateData['user_id'] = this.resume.user.id;
                updateData['user_email_ids'] = this.$store.state.userEmailIds;
                updateData['user_address_ids'] = this.$store.state.userAddressIds;
                updateData['user_phone_ids'] = this.$store.state.userPhoneIds;

                const success = await this.$store.dispatch('axiosPutRequest', {
                    route: '/resume/' + this.resume.id,
                    payload: updateData,
                    successMessage: 'Successfully saved contact information',
                });

                return success;
            },
        }
    }
</script>
