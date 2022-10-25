require('./bootstrap')

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import DashboardNavigation from './components/DashboardNavigation.vue'
import DashboardNavigationMobile from './components/DashboardNavigationMobile.vue'
import NavigationMenuButton from './components/NavigationMenuButton.vue'
import SwitchAccount from './components/SwitchAccount.vue'
import Transactions from './components/Transactions.vue'


const pinia = createPinia()
const app = createApp({})

app.component('dashboard-navigation', DashboardNavigation)
app.component('dashboard-navigation-mobile', DashboardNavigationMobile)
app.component('navigation-menu-button', NavigationMenuButton)
app.component('switch-account', SwitchAccount)
app.component('transactions', Transactions)



app.use(pinia)
app.mount('#app')
