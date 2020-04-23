// Profile menu animation
$('#navbar-top .links.icons').on('show.bs.dropdown', function() {
  $(this).find('.dropdown-menu').first().stop(true, true).slideToggle()
})
$('#navbar-top .links.icons').on('hide.bs.dropdown', function() {
  $(this).find('.dropdown-menu').first().stop(true, true).slideToggle()
})


// Mobile menu animation
$('#navbar-top .dropdown.mobile').on('show.bs.dropdown', function() {
  $(this).find('.dropdown-menu').first().stop(true, true).slideToggle()
})
$('#navbar-top .dropdown.mobile').on('hide.bs.dropdown', function() {
  $(this).find('.dropdown-menu').first().stop(true, true).slideToggle()
})

$(window).resize(() => {
  var numberOfColumns = 5
  if (screen.width <= 1024) numberOfColumns = 3
  if (screen.width <= 768) numberOfColumns = 2
  if (screen.width <= 425) numberOfColumns = 1
  window.artworkDimension = parseInt(screen.width / numberOfColumns)
  $('#aw-style').html(`
    .artwork { height: ${window.artworkDimension}px }
  `)

  if (screen.width <= 576) {
    var selectedContact = $('#contacts-list .contact.selected').length
    if (selectedContact) {
      $('#second-screen').css('left', '0')
      $('.message-composer').css('left', '0')
    }
  }

})

$(document).ready(function() {

  // Register form loader
  $('#register-form').on('submit', function() {
    loader.fire()
  })

  // Login form loader
  $('#login-form').on('submit', function() {
    loader.fire()
  })

})
