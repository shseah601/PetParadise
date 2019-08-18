<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12>
        <v-form ref="form" @submit.prevent="submit">
          <v-card>
            <progress-bar :show="busy"></progress-bar>
            <v-card-title class="grey lighten-4">
              <h3 class="headline mb-0">{{ $t('company') }}</h3>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
              <v-layout row wrap>
                <v-flex d-flex xs12 sm4 md3 lg3>
                  <v-img
                    :src="editedCompany.logo ? editedCompany.logo :defaultCompany.logo"
                    max-height="200"
                    min-width="100"
                    contain
                  ></v-img>
                </v-flex>
                <v-flex d-flex xs12 sm8 md9 lg9>
                  <v-layout justify-center column fill-height>
                    <v-card flat>
                      <v-card-title>
                        <h4 class="title font-weight-regular">Logo</h4>
                      </v-card-title>
                      <v-card-text>
                        <!-- <v-layout row wrap>
                          <v-flex xs12 sm12 md3>
                            <v-btn :disabled="busy" color="primary" @click="onPickFile">Upload Logo</v-btn>
                            <input
                              type="file"
                              v-show="false"
                              ref="fileInput"
                              accept="image/png"
                              @change="onFileUpload"
                            />
                          </v-flex>
                          <v-flex xs12 sm12 md9>
                            <v-layout justify-center column fill-height>
                              <div>{{imageName ? 'Uploaded: ' + imageName : ''}}</div>
                            </v-layout>
                          </v-flex>
                        </v-layout>-->
                      </v-card-text>
                    </v-card>
                  </v-layout>
                </v-flex>
                <v-flex d-flex xs12 sm12 md12 lg12>
                  <v-layout row wrap>
                    <v-flex xs12 sm12 md12 lg12>
                      <v-text-field
                        v-model="editedCompany.name"
                        :counter="100"
                        :rules="rules.name"
                        :disabled="busy"
                        label="Company Name"
                        required
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm12 md12 lg12>
                      <v-text-field
                        v-model="editedCompany.phone"
                        :rules="rules.phone"
                        :disabled="busy"
                        label="Phone"
                        required
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm12 md12 lg12>
                      <v-text-field
                        v-model="editedCompany.email"
                        :rules="rules.email"
                        :disabled="busy"
                        label="Email"
                        required
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm12 md12 lg12>
                      <v-text-field
                        v-model="editedCompany.address"
                        :rules="rules.address"
                        :disabled="busy"
                        label="Address"
                        required
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm12 md12 lg12>
                      <v-textarea
                        v-model="editedCompany.title"
                        :rules="rules.title"
                        :disabled="busy"
                        label="Description Title"
                        required
                      ></v-textarea>
                    </v-flex>
                    <v-flex xs12 sm12 md12 lg12>
                      <v-textarea
                        v-model="editedCompany.description"
                        :rules="rules.description"
                        :disabled="busy"
                        label="Description"
                        required
                      ></v-textarea>
                    </v-flex>
                  </v-layout>
                </v-flex>
              </v-layout>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn :disabled="busy" color="red lighten-1" class="white--text" @click="reset">Reset</v-btn>
              <v-btn
                :loading="busy"
                color="green lighten-1"
                class="white--text"
                @click="update"
              >Update</v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'admin-company-detail-view',
  metaInfo () {
    return { title: this.$t('company') }
  },
  data: () => ({
    defaultCompany: {
      name: '',
      phone: '',
      email: '',
      address: '',
      title: '',
      description: '',
      logo: ''
    },
    editedCompany: {
      name: '',
      phone: '',
      email: '',
      address: '',
      title: '',
      description: '',
      logo: '',
      image: null
    },
    imageName: null,
    busy: false,
    rules: {
      name: [
        v => !!v || 'Name is required',
        v => (v && v.length <= 100) || 'Name must be less than 100 characters'
      ],
      phone: [
        v => !!v || 'Phone is required',
        v => /^(0)[0-9][0-46-9][0-9]{6,7}$/.test(v) || 'Phone must be valid'
      ],
      email: [
        v => !!v || 'E-mail is required',
        v => /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'E-mail must be valid'
      ],
      address: [
        v => !!v || 'Address is required'
      ],
      title: [
        v => !!v || 'Description title is required'
      ],
      description: [
        v => !!v || 'Description is required'
      ]
    }
  }),
  computed: {
    ...mapGetters([
      'companyDetail'
    ])
  },
  async created () {
    this.initialize()
  },

  methods: {
    initialize () {
      this.company = this.companyDetail
      this.defaultCompany = Object.assign({}, this.company)
      this.editedCompany = Object.assign({}, this.defaultCompany)
    },
    onPickFile () {
      this.$refs.fileInput.click()
    },
    onFileUpload (event) {
      console.log(event.target.files)
      const files = event.target.files
      if (!files) {
        this.imageName = null
        return
      }
      this.imageName = files[0].name
      const index = this.imageName.lastIndexOf('.')
      if (this.imageName.substring(index) !== '.png') {
        return alert('Please add a valid image!')
      }
      const fileReader = new FileReader()
      fileReader.readAsDataURL(files[0])

      fileReader.addEventListener('load', () => {
        this.editedCompany.logo = fileReader.result
      })
      this.editedCompany.image = files
      console.log('files', this.editedCompany.image)
      console.log('image', files[0])
    },
    reset () {
      this.editedCompany = Object.assign({}, this.defaultCompany)
      this.$refs.form.resetValidation()
    },
    async update () {
      if (!this.$refs.form.validate()) return
      console.log(this.editedCompany)
      this.busy = true
      // const formData = new FormData()
      // formData.append('name', this.editedCompany.name)
      // formData.append('phone', this.editedCompany.phone)
      // formData.append('email', this.editedCompany.email)
      // formData.append('address', this.editedCompany.address)
      // formData.append('title', this.editedCompany.title)
      // formData.append('description', this.editedCompany.description)
      // formData.append('logo', this.editedCompany.logo)
      // formData.append('title', this.editedCompany.title)
      // formData.append('image', this.editedCompany.image)
      // const { data } = await axios.post('/api/company/1', formData, { headers: { 'Content-Type': 'multipart/form-data' } })
      // await axios({
      //   url: '/api/company/1',
      //   baseURL: 'http://localhost:8087',
      //   headers: { 'content-type': 'multipart/form-data' },
      //   data: formData,
      //   method: 'post'
      // })
      await this.$store.dispatch('updateCompany', this.editedCompany)
      this.defaultCompany = Object.assign({}, this.editedCompany)
      this.busy = false
      this.$store.dispatch('responseMessage', {
        type: 'success',
        text: 'Successfully Updated Company Detail'
      })
    }
  }
}
</script>
