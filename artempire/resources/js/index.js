// Dependencies
require('./bootstrap.js')

// Global script
require('./global.js')

// Build Vue app if we are not on these pages
var routes = ['/', '/register', '/login']
if (!routes.includes(location.pathname))
  require('./vue/app.js')
