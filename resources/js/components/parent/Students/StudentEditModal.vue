<template>
  <TransitionRoot
    v-if="this.isRequestEndSuccessfully"
    as="template"
    :show="this.isStudentEditVisible"
  >
    <Dialog
      as="div"
      class="relative z-10"
      @close="
        this.isStudentEditVisible = false;
        this.studentId = null;
      "
    >
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div
          class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        />
      </TransitionChild>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div
          class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
        >
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel
              class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
            >
              <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button
                  type="button"
                  class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                  @click="
                    this.isStudentEditVisible = false;
                    this.studentId = null;
                  "
                >
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>
              <Form
                id="form"
                @submit="
                  onSubmit();
                  this.studentId = null;
                "
                class="mt-8 space-y-6 w-full"
              >
                <div class="bg-white p-8">
                  <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                      Personal Information
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                      Use a permanent address where you can receive mail.
                    </p>
                  </div>
                  <div
                    class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6"
                  >
                    <div class="sm:col-span-2">
                      <label
                        for="last_name"
                        class="block text-sm font-medium text-gray-700"
                        >Last name</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          required
                          v-model="this.studentForEdit.last_name"
                          name="last_name"
                          id="last_name"
                          autocomplete="given-name"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="last_name">
                          <p class="text-red-500 text-sm">
                            last name field is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="first-name"
                        class="block text-sm font-medium text-gray-700"
                        >First name</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          v-model="this.studentForEdit.first_name"
                          required
                          name="first_name"
                          id="first_name"
                          autocomplete="family-name"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="first_name"
                          class="text-red-500 text-sm"
                        >
                          <p class="text-red-500 text-sm">
                            first name field is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>
                    <div class="sm:col-span-2">
                      <label
                        for="middle-name"
                        class="block text-sm font-medium text-gray-700"
                        >Middle name</label
                      >
                      <div class="mt-1">
                        <Field
                          type="text"
                          v-model="this.studentForEdit.middle_name"
                          name="middle_name"
                          id="middle_name"
                          autocomplete="additional-name"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="middle_name"
                          class="text-red-500 text-sm"
                        ></ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-3">
                      <label
                        for="country"
                        class="block text-sm font-medium text-gray-700"
                        >Country</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          name="country"
                          v-model="this.studentForEdit.user_information.country"
                        >
                          <select
                            v-model="
                              this.studentForEdit.user_information.country
                            "
                            id="country"
                            name="country"
                            autocomplete="country-name"
                            class="block w-full px-4 py-1.5 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                          >
                            <option value="AF">Afghanistan</option>
                            <option value="AX">Aland Islands</option>
                            <option value="AL">Albania</option>
                            <option value="DZ">Algeria</option>
                            <option value="AS">American Samoa</option>
                            <option value="AD">Andorra</option>
                            <option value="AO">Angola</option>
                            <option value="AI">Anguilla</option>
                            <option value="AQ">Antarctica</option>
                            <option value="AG">Antigua and Barbuda</option>
                            <option value="AR">Argentina</option>
                            <option value="AM">Armenia</option>
                            <option value="AW">Aruba</option>
                            <option value="AU">Australia</option>
                            <option value="AT">Austria</option>
                            <option value="AZ">Azerbaijan</option>
                            <option value="BS">Bahamas</option>
                            <option value="BH">Bahrain</option>
                            <option value="BD">Bangladesh</option>
                            <option value="BB">Barbados</option>
                            <option value="BY">Belarus</option>
                            <option value="BE">Belgium</option>
                            <option value="BZ">Belize</option>
                            <option value="BJ">Benin</option>
                            <option value="BM">Bermuda</option>
                            <option value="BT">Bhutan</option>
                            <option value="BO">Bolivia</option>
                            <option value="BQ">
                              Bonaire, Sint Eustatius and Saba
                            </option>
                            <option value="BA">Bosnia and Herzegovina</option>
                            <option value="BW">Botswana</option>
                            <option value="BV">Bouvet Island</option>
                            <option value="BR">Brazil</option>
                            <option value="IO">
                              British Indian Ocean Territory
                            </option>
                            <option value="BN">Brunei Darussalam</option>
                            <option value="BG">Bulgaria</option>
                            <option value="BF">Burkina Faso</option>
                            <option value="BI">Burundi</option>
                            <option value="KH">Cambodia</option>
                            <option value="CM">Cameroon</option>
                            <option value="CA">Canada</option>
                            <option value="CV">Cape Verde</option>
                            <option value="KY">Cayman Islands</option>
                            <option value="CF">Central African Republic</option>
                            <option value="TD">Chad</option>
                            <option value="CL">Chile</option>
                            <option value="CN">China</option>
                            <option value="CX">Christmas Island</option>
                            <option value="CC">Cocos (Keeling) Islands</option>
                            <option value="CO">Colombia</option>
                            <option value="KM">Comoros</option>
                            <option value="CG">Congo</option>
                            <option value="CD">
                              Congo, Democratic Republic of the Congo
                            </option>
                            <option value="CK">Cook Islands</option>
                            <option value="CR">Costa Rica</option>
                            <option value="CI">Cote D'Ivoire</option>
                            <option value="HR">Croatia</option>
                            <option value="CU">Cuba</option>
                            <option value="CW">Curacao</option>
                            <option value="CY">Cyprus</option>
                            <option value="CZ">Czech Republic</option>
                            <option value="DK">Denmark</option>
                            <option value="DJ">Djibouti</option>
                            <option value="DM">Dominica</option>
                            <option value="DO">Dominican Republic</option>
                            <option value="EC">Ecuador</option>
                            <option value="EG">Egypt</option>
                            <option value="SV">El Salvador</option>
                            <option value="GQ">Equatorial Guinea</option>
                            <option value="ER">Eritrea</option>
                            <option value="EE">Estonia</option>
                            <option value="ET">Ethiopia</option>
                            <option value="FK">
                              Falkland Islands (Malvinas)
                            </option>
                            <option value="FO">Faroe Islands</option>
                            <option value="FJ">Fiji</option>
                            <option value="FI">Finland</option>
                            <option value="FR">France</option>
                            <option value="GF">French Guiana</option>
                            <option value="PF">French Polynesia</option>
                            <option value="TF">
                              French Southern Territories
                            </option>
                            <option value="GA">Gabon</option>
                            <option value="GM">Gambia</option>
                            <option value="GE">Georgia</option>
                            <option value="DE">Germany</option>
                            <option value="GH">Ghana</option>
                            <option value="GI">Gibraltar</option>
                            <option value="GR">Greece</option>
                            <option value="GL">Greenland</option>
                            <option value="GD">Grenada</option>
                            <option value="GP">Guadeloupe</option>
                            <option value="GU">Guam</option>
                            <option value="GT">Guatemala</option>
                            <option value="GG">Guernsey</option>
                            <option value="GN">Guinea</option>
                            <option value="GW">Guinea-Bissau</option>
                            <option value="GY">Guyana</option>
                            <option value="HT">Haiti</option>
                            <option value="HM">
                              Heard Island and Mcdonald Islands
                            </option>
                            <option value="VA">
                              Holy See (Vatican City State)
                            </option>
                            <option value="HN">Honduras</option>
                            <option value="HK">Hong Kong</option>
                            <option value="HU">Hungary</option>
                            <option value="IS">Iceland</option>
                            <option value="IN">India</option>
                            <option value="ID">Indonesia</option>
                            <option value="IR">
                              Iran, Islamic Republic of
                            </option>
                            <option value="IQ">Iraq</option>
                            <option value="IE">Ireland</option>
                            <option value="IM">Isle of Man</option>
                            <option value="IL">Israel</option>
                            <option value="IT">Italy</option>
                            <option value="JM">Jamaica</option>
                            <option value="JP">Japan</option>
                            <option value="JE">Jersey</option>
                            <option value="JO">Jordan</option>
                            <option value="KZ">Kazakhstan</option>
                            <option value="KE">Kenya</option>
                            <option value="KI">Kiribati</option>
                            <option value="KP">
                              Korea, Democratic People's Republic of
                            </option>
                            <option value="KR">Korea, Republic of</option>
                            <option value="XK">Kosovo</option>
                            <option value="KW">Kuwait</option>
                            <option value="KG">Kyrgyzstan</option>
                            <option value="LA">
                              Lao People's Democratic Republic
                            </option>
                            <option value="LV">Latvia</option>
                            <option value="LB">Lebanon</option>
                            <option value="LS">Lesotho</option>
                            <option value="LR">Liberia</option>
                            <option value="LY">Libyan Arab Jamahiriya</option>
                            <option value="LI">Liechtenstein</option>
                            <option value="LT">Lithuania</option>
                            <option value="LU">Luxembourg</option>
                            <option value="MO">Macao</option>
                            <option value="MK">
                              Macedonia, the Former Yugoslav Republic of
                            </option>
                            <option value="MG">Madagascar</option>
                            <option value="MW">Malawi</option>
                            <option value="MY">Malaysia</option>
                            <option value="MV">Maldives</option>
                            <option value="ML">Mali</option>
                            <option value="MT">Malta</option>
                            <option value="MH">Marshall Islands</option>
                            <option value="MQ">Martinique</option>
                            <option value="MR">Mauritania</option>
                            <option value="MU">Mauritius</option>
                            <option value="YT">Mayotte</option>
                            <option value="MX">Mexico</option>
                            <option value="FM">
                              Micronesia, Federated States of
                            </option>
                            <option value="MD">Moldova, Republic of</option>
                            <option value="MC">Monaco</option>
                            <option value="MN">Mongolia</option>
                            <option value="ME">Montenegro</option>
                            <option value="MS">Montserrat</option>
                            <option value="MA">Morocco</option>
                            <option value="MZ">Mozambique</option>
                            <option value="MM">Myanmar</option>
                            <option value="NA">Namibia</option>
                            <option value="NR">Nauru</option>
                            <option value="NP">Nepal</option>
                            <option value="NL">Netherlands</option>
                            <option value="AN">Netherlands Antilles</option>
                            <option value="NC">New Caledonia</option>
                            <option value="NZ">New Zealand</option>
                            <option value="NI">Nicaragua</option>
                            <option value="NE">Niger</option>
                            <option value="NG">Nigeria</option>
                            <option value="NU">Niue</option>
                            <option value="NF">Norfolk Island</option>
                            <option value="MP">Northern Mariana Islands</option>
                            <option value="NO">Norway</option>
                            <option value="OM">Oman</option>
                            <option value="PK">Pakistan</option>
                            <option value="PW">Palau</option>
                            <option value="PS">
                              Palestinian Territory, Occupied
                            </option>
                            <option value="PA">Panama</option>
                            <option value="PG">Papua New Guinea</option>
                            <option value="PY">Paraguay</option>
                            <option value="PE">Peru</option>
                            <option value="PH">Philippines</option>
                            <option value="PN">Pitcairn</option>
                            <option value="PL">Poland</option>
                            <option value="PT">Portugal</option>
                            <option value="PR">Puerto Rico</option>
                            <option value="QA">Qatar</option>
                            <option value="RE">Reunion</option>
                            <option value="RO">Romania</option>
                            <option value="RU">Russian Federation</option>
                            <option value="RW">Rwanda</option>
                            <option value="BL">Saint Barthelemy</option>
                            <option value="SH">Saint Helena</option>
                            <option value="KN">Saint Kitts and Nevis</option>
                            <option value="LC">Saint Lucia</option>
                            <option value="MF">Saint Martin</option>
                            <option value="PM">
                              Saint Pierre and Miquelon
                            </option>
                            <option value="VC">
                              Saint Vincent and the Grenadines
                            </option>
                            <option value="WS">Samoa</option>
                            <option value="SM">San Marino</option>
                            <option value="ST">Sao Tome and Principe</option>
                            <option value="SA">Saudi Arabia</option>
                            <option value="SN">Senegal</option>
                            <option value="RS">Serbia</option>
                            <option value="CS">Serbia and Montenegro</option>
                            <option value="SC">Seychelles</option>
                            <option value="SL">Sierra Leone</option>
                            <option value="SG">Singapore</option>
                            <option value="SX">Sint Maarten</option>
                            <option value="SK">Slovakia</option>
                            <option value="SI">Slovenia</option>
                            <option value="SB">Solomon Islands</option>
                            <option value="SO">Somalia</option>
                            <option value="ZA">South Africa</option>
                            <option value="GS">
                              South Georgia and the South Sandwich Islands
                            </option>
                            <option value="SS">South Sudan</option>
                            <option value="ES">Spain</option>
                            <option value="LK">Sri Lanka</option>
                            <option value="SD">Sudan</option>
                            <option value="SR">Suriname</option>
                            <option value="SJ">Svalbard and Jan Mayen</option>
                            <option value="SZ">Swaziland</option>
                            <option value="SE">Sweden</option>
                            <option value="CH">Switzerland</option>
                            <option value="SY">Syrian Arab Republic</option>
                            <option value="TW">
                              Taiwan, Province of China
                            </option>
                            <option value="TJ">Tajikistan</option>
                            <option value="TZ">
                              Tanzania, United Republic of
                            </option>
                            <option value="TH">Thailand</option>
                            <option value="TL">Timor-Leste</option>
                            <option value="TG">Togo</option>
                            <option value="TK">Tokelau</option>
                            <option value="TO">Tonga</option>
                            <option value="TT">Trinidad and Tobago</option>
                            <option value="TN">Tunisia</option>
                            <option value="TR">Turkey</option>
                            <option value="TM">Turkmenistan</option>
                            <option value="TC">Turks and Caicos Islands</option>
                            <option value="TV">Tuvalu</option>
                            <option value="UG">Uganda</option>
                            <option value="UA">Ukraine</option>
                            <option value="AE">United Arab Emirates</option>
                            <option value="GB">United Kingdom</option>
                            <option value="US">United States</option>
                            <option value="UM">
                              United States Minor Outlying Islands
                            </option>
                            <option value="UY">Uruguay</option>
                            <option value="UZ">Uzbekistan</option>
                            <option value="VU">Vanuatu</option>
                            <option value="VE">Venezuela</option>
                            <option value="VN">Viet Nam</option>
                            <option value="VG">Virgin Islands, British</option>
                            <option value="VI">Virgin Islands, U.s.</option>
                            <option value="WF">Wallis and Futuna</option>
                            <option value="EH">Western Sahara</option>
                            <option value="YE">Yemen</option>
                            <option value="ZM">Zambia</option>
                            <option value="ZW">Zimbabwe</option>
                          </select>
                        </Field>

                        <ErrorMessage
                          name="country"
                          class="text-red-500 text-sm"
                        >
                          <p class="text-red-500 text-sm">
                            country field is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-6">
                      <label
                        for="street_address"
                        class="block text-sm font-medium text-gray-700"
                        >Street address</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          v-model="
                            this.studentForEdit.user_information.street_address
                          "
                          type="text"
                          name="street_address"
                          id="street_address"
                          autocomplete="street-address"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="street_address"
                          class="text-red-500 text-sm"
                        >
                          <p class="text-red-500 text-sm">
                            street address field is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="city"
                        class="block text-sm font-medium text-gray-700"
                        >City</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          v-model="this.studentForEdit.user_information.city"
                          name="city"
                          id="city"
                          autocomplete="address-level2"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="city" class="text-red-500 text-sm">
                          <p class="text-red-500 text-sm">
                            city field is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="state"
                        class="block text-sm font-medium text-gray-700"
                        >State / Province</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          v-model="this.studentForEdit.user_information.state"
                          name="state"
                          id="state"
                          autocomplete="address-level1"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="state" class="text-red-500 text-sm">
                          <p class="text-red-500 text-sm">
                            state field is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="zip"
                        class="block text-sm font-medium text-gray-700"
                        >ZIP / Postal code</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          v-model="this.studentForEdit.user_information.zip"
                          name="zip"
                          id="zip"
                          autocomplete="postal-code"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="zip" class="text-red-500 text-sm">
                          <p class="text-red-500 text-sm">
                            zip field is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>
                  </div>
                  <div class="pt-5">
                    <div class="flex justify-end">
                      <button
                        type="submit"
                        class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                      >
                        Save
                      </button>
                    </div>
                  </div>
                </div>
              </Form>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { ExclamationTriangleIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import { mapActions, mapWritableState } from "pinia";
import { useStudentStore } from "@/stores/useStudentStore";
import { useModalStore } from "@/stores/useModalStore";
import { Form, Field, ErrorMessage } from "vee-validate";

export default {
  data() {
    return {
      isRequestEndSuccessfully: false,
    };
  },
  components: {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    ExclamationTriangleIcon,
    XMarkIcon,
    Form,
    Field,
    ErrorMessage,
  },
  computed: {
    ...mapWritableState(useStudentStore, [
      "studentForEdit",
      "studentId",
      "students",
    ]),
    ...mapWritableState(useModalStore, ["isStudentEditVisible"]),
  },
  methods: {
    ...mapActions(useModalStore, ["showHideStudentEdit"]),
    onSubmit() {
      axios
        .post(`/api/parent/update-student`, {
          student_id: this.studentForEdit.id,
          first_name: this.studentForEdit.first_name,
          last_name: this.studentForEdit.last_name,
          middle_name: this.studentForEdit.middle_name,
          country: this.studentForEdit.user_information.country,
          city: this.studentForEdit.user_information.city,
          state: this.studentForEdit.user_information.state,
          street_address: this.studentForEdit.user_information.street_address,
          zip: this.studentForEdit.user_information.zip,
        })
        .then((res) => {
          this.students = res.data.data;
        })
        .finally(() => {
          this.isStudentEditVisible = false;
        });
    },
    handleGetStudentRequest() {
      axios.get(`/api/parent/student/${this.studentId}`).then((res) => {
        this.studentForEdit = res.data.data;
        this.isRequestEndSuccessfully = true;
      });
    },
  },
  created() {
    this.handleGetStudentRequest();
  },
};
</script>
