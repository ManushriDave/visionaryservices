<template>
    <div v-if="user.hasOwnProperty('avatar')">
        <!-- Active Chat User -->
        <div class="js-chat-active-user p-15 d-flex align-items-center justify-content-between bg-white">
            <div class="d-flex align-items-center">
                <a class="img-link img-status" href="javascript:void(0)">
                    <img class="img-avatar img-avatar32" :src="user.user_b.avatar" alt="Avatar">
                    <div class="img-status-indicator bg-success"></div>
                </a>
                <div class="ml-10">
                    <a class="font-w600" href="javascript:void(0)">{{ user.user_b.name }}</a>
                    <div class="font-size-sm text-muted">{{ room.is_nifty ? 'User' : 'Nifty' }}</div>
                </div>
            </div>
        </div>
        <!-- END Active Chat User -->

        <!-- Chat Window -->
        <div class="js-chat-window p-15 bg-light flex-grow-1 text-wrap-break-word overflow-y-auto">
            <!-- User Message -->
            <div
                v-for="(message, index) in messages"
                :class="
                    ['d-flex mb-20 '] +
                    [message.is_mine && 'flex-row-reverse']
                "
                :key="index"
            >
                <div>
                    <a class="img-link img-status" href="javascript:void(0)">
                        <img class="img-avatar img-avatar32" :src="message.is_mine ? user.avatar : user.user_b.avatar" alt="Avatar">
                        <div class="img-status-indicator bg-success"></div>
                    </a>
                </div>
                <div class="mx-10" style="width: 50%;">
                    <div>
                        <p :class="['text-dark rounded px-15 py-10 mb-5 '] + [message.is_mine ? 'bg-primary-lighter' : 'bg-body-dark']">
                            {{ message.message }}
                        </p>
                    </div>
                    <div class="text-right text-muted font-size-xs font-italic">{{ message.time }}</div>
                <!--<div class="text-muted font-size-xs font-italic">10 min ago</div>-->
                </div>
            </div>
            <!-- END User Message -->
        </div>
        <!-- END Chat Window -->

        <!-- Chat Input -->
        <div class="js-chat-message p-10 mt-auto">
            <div class="d-flex align-items-center">
                <input
                    @keydown="sendTypingEvent"
                    @keyup.enter="sendMessage"
                    v-model="newMessage"
                    type="text"
                    name="message"
                    class="form-control flex-grow mr-5"
                    placeholder="Type a message.."
                />
            </div>
        </div>
        <!-- END Chat Input -->
    </div>
</template>

<script>
export default {

    props: ['room'],

    data() {
        return {
            messages: [],
            newMessage: '',
            users: [],
            user: {},
            activeUser: false,
            typingTimer: false,
        }
    },

    created() {
        this.getUser();

        Echo.join(`chat.${this.room.id}`)
            .here(user => {
                this.users = user;
            })
            .joining(user => {
                this.users.push(user);
            })
            .leaving(user => {
                this.users = this.users.filter(u => u.id !== user.id);
            })
            .listen('MessageSent',(event) => {
                this.messages.push(event.message);
                this.scrollDown();
            })
            .listenForWhisper('typing', user => {
                this.activeUser = user;

                if(this.typingTimer) {
                    clearTimeout(this.typingTimer);
                }

                this.typingTimer = setTimeout(() => {
                    this.activeUser = false;
                }, 3000);
            })
    },

    methods: {
        getUser() {
            window.axios.defaults.headers.common = {'Authorization': `Bearer ${this.room.token}`};
            if (this.room.is_nifty) {
                window.axios.defaults.headers.common['nifty'] = true;
            }
            axios.get('/api/chat/room/' + this.room.id).then(response => {
                this.user = response.data;
                setTimeout(() => {
                    let token = this.user.token.token;
                    localStorage.setItem('token', token);
                    window.Echo.connector.pusher.config.auth.headers['Authorization'] = `Bearer ${token}`;


                    this.fetchMessages();
                }, 500);
            })
        },

        fetchMessages() {
            axios.get('/api/chat/messages/' + this.room.id).then(response => {
                this.messages = response.data;
                setTimeout(() => {
                    this.scrollDown();
                }, 500);
            })
        },

        sendMessage() {
            if (this.newMessage.search(/\b[a-z0-9._%+?\-]+@[a-z0-9.-]+?\.[a-z]{2,4}\b/i) !== -1)
            {
                alert('Sorry! You cannot send an email address or phone no.');
                return;
            }

            if (this.newMessage.search(/\b[a-z0-9.-]+?\.[a-z]{2,4}\b/i) !== -1)
            {
                alert('Sorry! You cannot send a website link.');
                return;
            }

            let Regex = /\b[\+]?[(]?[0-9]{2,6}[)]?[-\s\.]?[-\s\/\.0-9]{3,15}\b/m;

            if (Regex.test(this.newMessage.replace(' ', ''))) {
                alert('Sorry! You cannot send a Phone no..');
                return;
            }

            let not_allowed = ['@', 'gmail', 'yahoo', '.com', '. c', 'c o m', ];
            let found = false;
            not_allowed.map(el => {
                if (this.newMessage.includes(el)) {
                    alert('Sorry! You cannot send this message..');
                    found = true;
                }
            });

            if (found) {
                return;
            }

            this.messages.push({
                user      : this.user,
                message   : this.newMessage,
                from_user : !this.user.is_nifty,
                is_mine   : true,
                time      : 'Sent',
            });

            axios.post('/api/chat/message', {
                'user'      : this.user,
                'message'   : this.newMessage,
                'room_id'   : this.room.id,
                'from_user' : !this.room.is_nifty,
            });

            this.scrollDown();

            this.newMessage = '';
        },

        scrollDown() {
            let elem = $('.js-chat-window');
            elem.animate({ scrollTop: elem.prop('scrollHeight')}, 1000);
            elem.scrollTop = elem.scrollHeight;
        },

        sendTypingEvent() {
            Echo.join(`chat.${this.room.id}`)
                .whisper('typing', this.user);
        }
    }
}
</script>
