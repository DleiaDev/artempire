// SASS
import '../sass/app.scss'

// jQuery
import $ from 'jquery'
window.$ = $

// Bootstrap
import 'bootstrap/dist/js/bootstrap.min.js'

// Axios
import axios from 'axios'
window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
let token = document.head.querySelector('meta[name="csrf-token"]')
if (token) window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content

// Sweetalert2
import Swal from 'sweetalert2';
window.Swal = Swal
window.toast = Swal.mixin({
  customClass: {container: 'swal-toast-container'},
  toast: true,
  position: 'top-start',
  showConfirmButton: false,
  timer: 4000
})
window.loader = Swal.mixin({
  timer: 300000,
  customClass: {container: 'swal-loader-container'},
  allowOutsideClick: false,
  allowEscapeKey: false,
  allowEnterKey: false,
  onBeforeOpen: () => {
    Swal.showLoading()
  }
})

// Moment
import moment from 'moment'
window.moment = moment

// Pusher
import Pusher from 'pusher-js'
var pusher = new Pusher('fed99312c5dcf4632c25', {
  cluster: 'eu',
  encrypted: true
})
// Pusher.logToConsole = true

// Laravel Echo
import Echo from 'laravel-echo'
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'fed99312c5dcf4632c25',
    cluster: 'eu',
    encrypted: true
})
