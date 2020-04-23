import Vue from 'vue'
window.Vue = Vue

// Algolia for Vue
import InstantSearch from 'vue-instantsearch'
Vue.use(InstantSearch)

// Components
import Home from './components/Home.vue'
import Search from './components/Search.vue'
import Artwork from './components/Artwork.vue'
import Upload from './components/Upload.vue'
import Chat from './components/Chat.vue'
import Account from './components/Account.vue'
import Profile from './components/Profile.vue'
import MyProfile from './components/MyProfile.vue'

// Vue router
import VueRouter from 'vue-router'
Vue.use(VueRouter)
var router = new VueRouter({
  routes: [
    {path: '/home', component: Home},
    {path: '/search', component: Search},
    {path: '/upload', component: Upload},
    {path: '/chat', component: Chat},
    {path: '/account', component: Account},
    {path: `/user/${user.username}`, component: MyProfile},
    {path: '/user/:username', component: Profile},
    {path: '/artworks/:id', component: Artwork}
  ],
  mode: 'history'
})

// vForm
import { Form, HasError, AlertError } from 'vform'
window.Form = Form
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

// Filters
Vue.filter('shorten', text => {
  return text.length > 25 ? text.substring(0, 25) + '...' : text;
});
Vue.filter('relative', date => {
  var momentDate = moment(new Date(date))
  if (timezoneOffset > 0) momentDate.add(timezoneOffset, 'hours')
  else momentDate.subtract(timezoneOffset, 'hours')
  return momentDate.fromNow()
})
Vue.filter('time', date => {
  return moment(date).format('LT')
})

window.timezoneOffset = (new Date).getTimezoneOffset() / 60
Vue.prototype.$user = window.user
Vue.prototype.$profile = window.profile

var numberOfColumns = 5
if (screen.width <= 1024) numberOfColumns = 3
if (screen.width <= 768) numberOfColumns = 2
if (screen.width <= 425) numberOfColumns = 1
window.artworkDimension = parseInt(screen.width / numberOfColumns)
Vue.prototype.$artworkDimension = artworkDimension

Vue.prototype.$toCloudinary = function(artworks) {
  if (!artworks.length) return []
  var k = 1.06
  if (screen.width <= 425) k = 2 // Higher resolution for mobile
  var dimension = parseInt(Vue.prototype.$artworkDimension * k)
  var position = artworks[0].image.search('upload/') + 7
  for (var i = 0; i < artworks.length; i++) {
    artworks[i].image = [
      artworks[i].image.slice(0, position),
      `w_${dimension},h_${dimension},c_fill/`,
      artworks[i].image.slice(position)
    ].join('')
  }
  return artworks
}

import App from './App.vue'
var vm = new Vue({
  el: '#vue',
  render: h => h(App),
  router
})
window.vm = vm

$(document).ready(() => {
  $('head').append(`<style id="aw-style">.artwork { height: ${artworkDimension}px }</style>`)
})
