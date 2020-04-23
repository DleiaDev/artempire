<template>
  <div id="chat">
    <div class="card">

      <!-- Main screen -->
      <div id="main-screen">

        <!-- Header -->
        <div class="header">
          <div class="contact-photo">
            <a :href="`/user/${$user.username}`" class="image background" :style="`background-image: url(${$user.profile})`"></a>
            <div class="status online"></div>
          </div>
          <a :href="`/user/${$user.username}`" class="username">{{ $user.username }}</a>
        </div>

        <!-- Contacts -->
        <div id="contacts-container">
          <ContactsList
            :contacts="contacts"
            @selected="getMessages">
          </ContactsList>
        </div>

      </div>

      <!-- Chat screen -->
      <Conversation
        :contact="selectedContact"
        :messages="messages"
        @loadMore="loadMoreMessages"
        @messagesSeen="seeMessages"
        @back="closeConversation">
      </Conversation>

    </div>
  </div>
</template>

<script>
import ContactsList from './chat/ContactsList.vue'
import Conversation from './chat/Conversation.vue'

export default {
  components: {ContactsList, Conversation},

  data() {
    return {
      contacts: {},
      messagesPerContact: {},
      messages: [],
      selectedContact: {}
    }
  },

  methods: {
    getContact(id) {
      axios.get(`/api/chat/contacts/${id}`)
        .then(response => {
          response.data.online = true
          this.$set(this.contacts, id, response.data)
        })
    },
    getMessages(contactID) {
      $(`#contact-${contactID}`).addClass('selected')

      this.messages = []
      this.selectedContact = this.contacts[contactID]

      if (this.messagesPerContact[contactID]) {
        this.messages = this.messagesPerContact[contactID]
        if (window.screen.width <= 576) this.slideConversation()
        return this.seeMessages(this.selectedContact)
      }

      loader.fire()
      axios.get(`/api/chat/contacts/${contactID}/messages`)
      .then(response => {
        loader.close()
        this.messages = response.data
        this.$set(this.messagesPerContact, contactID, response.data)
        this.seeMessages(this.selectedContact)
        if (response.data.length < 50)
          this.contacts[contactID].hasNoMoreMessages = true
        if (window.screen.width <= 576) this.slideConversation()
      })

    },
    loadMoreMessages(contactID) {
      loader.fire()
      this.contacts[contactID].scrolls++
      var scrolls = this.contacts[contactID].scrolls
      axios.get(`/api/chat/contacts/${contactID}/messages?scrolls=${scrolls}`)
      .then(response => {
        loader.close()
        this.messages = response.data.concat(this.messages)
        this.messagesPerContact[contactID] = response.data.concat(this.messagesPerContact[contactID])
        if (response.data.length < 50)
          this.contacts[contactID].hasNoMoreMessages = true
      })
    },
    seeMessages(selectedContact) {
      if (selectedContact.lastMessage.to != this.$user.id) return
      var contactID = selectedContact.id
      this.messagesPerContact[contactID].forEach(message => message.read = true)
      this.contacts[contactID].lastMessage.read = true
      this.contacts[contactID].unread = 0
      axios.post('/api/chat/seen', {
        currentUser_id: this.$user.id,
        contact_id: contactID
      })
    },
    handleIncoming(message) {
      var contactID = message.from

      if (!this.contacts[contactID])
        return this.getContact(message.from)

      // This also pushes into this.messages somehow?
      if (this.messagesPerContact[contactID])
        this.messagesPerContact[contactID].push(message)

      this.contacts[contactID].unread++
      this.contacts[contactID].lastMessage = message

      axios.post('/api/chat/receive', {
        contactWhoSent: message.from,
        message_id: message.id
      })
    },
    slideConversation(selectedContact) {
      setTimeout(() => {
        $('#second-screen').animate({left: 0})
        $('.message-composer').animate({left: 0})
      }, 50)
    },
    closeConversation() {
      $('.contact').removeClass('selected')
      if (window.screen.width <= 576) {
        $('.message-composer').animate({left: '-150%'})
        $('#second-screen').animate(
          {left: '-150%'},
          function() {
            this.messages = []
            this.selectedContact = {}
          }
        )
      } else {
        this.messages = []
        this.selectedContact = {}
      }
    },
  },

  created() {
    Echo.private(`messages.${this.$user.id}`)
    .listen('.NewMessageEvent', event => {
      event.message.received = true
      if (this.selectedContact.id === event.message.from)
        event.message.read = true
      this.handleIncoming(event.message)
    })
    .listen('.MessageReceivedEvent', event => {
      if (this.selectedContact.id != event.contact_id) return
      this.messages.forEach(message => message.received = true)
    })
    .listen('.MessagesSeenEvent', event => {
      var contactID = event.contact_id
      this.contacts[contactID].lastMessage.read = true
      if (this.messagesPerContact[contactID])
        this.messagesPerContact[contactID].forEach(message => message.read = true)
      if (this.selectedContact.id === contactID)
        this.messages.forEach(message => message.read = true)
    })

    loader.fire()
    Echo.join('presence-status')
    .here(onlineUsers => {
      axios.get('/api/chat/contacts')
      .then(response => {
        loader.close()
        response.data.forEach(contact => {
          onlineUsers.forEach(onlineUser => {
            if (contact.id === onlineUser.id)
              contact.online = true
          })
          this.$set(this.contacts, contact.id, contact)
        })
      })
    })
    .joining(user => {
      if (this.contacts[user.id])
        this.contacts[user.id].online = true

      // Receive all messages
      if (this.messagesPerContact[user.id])
        this.messagesPerContact[user.id].forEach(message => message.received = true)
      if (this.selectedContact.id === user.id)
        this.messages.forEach(message => message.received = true)
    })
    .leaving(user => {
      if (this.contacts[user.id])
        this.contacts[user.id].online = false
    })
  }

}
</script>
