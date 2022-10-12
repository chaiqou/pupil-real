require('./bootstrap')

import { createApp } from 'vue'
import SetupAccount from './components/SetupAccount.vue'

const app = createApp({})

app.component('setup-account', SetupAccount)

app.mount('#app')
