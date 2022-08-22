import App from './App'

// #ifndef VUE3
import Vue from 'vue'
import {setBarTitle,checkPhone,checkPwd,myRequest} from "js/api.js"
Vue.config.productionTip = false
Vue.prototype.$myfuns = {setBarTitle,checkPhone,checkPwd,myRequest}
App.mpType = 'app'
const app = new Vue({
    ...App
})
app.$mount()
// #endif

// #ifdef VUE3
import { createSSRApp } from 'vue'
export function createApp() {
  const app = createSSRApp(App)
  return {
    app
  }
}
// #endif