import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { createVuetify } from 'vuetify'
import 'vuetify/styles'

const app = createApp(App)

const vuetify = createVuetify({
    components,
    directives
})

app.use(router)
app.use(vuetify)
app.mount('#app')
