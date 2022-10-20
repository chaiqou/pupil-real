require('./bootstrap')

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import DashboardNavigation from './components/DashboardNavigation.vue'
import DashboardNavigationMobile from './components/DashboardNavigationMobile.vue'
import NavigationMenuButton from './components/NavigationMenuButton.vue'
import SwitchAccount from './components/SwitchAccount.vue'
import SelectStudents from './components/SelectStudents.vue'

const pinia = createPinia()
const app = createApp({})

app.component('dashboard-navigation', DashboardNavigation)
app.component('dashboard-navigation-mobile', DashboardNavigationMobile)
app.component('navigation-menu-button', NavigationMenuButton)
app.component('switch-account', SwitchAccount)
app.component('select-students', SelectStudents)

app.use(pinia)
app.mount('#app')
