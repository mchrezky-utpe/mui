<div class="tw-contents">
    <!-- Triggers  -->

    <!-- Message Trigger  -->

    @if(false)
    <div class="tw-contents">
        <!-- Message Trigger -->
        <button
            x-on:click="$dispatch('notify', { variant: 'message', sender:{name:'Jack Ellis', avatar:'https://penguinui.s3.amazonaws.com/component-assets/avatar-2.webp'}, message: 'Hey, can you review the PR I just submitted? Let me know if you spot any issues!' })"
            type="button"
            class="tw-whitespace-nowrap tw-rounded-sm tw-bg-sky-700 tw-px-4 tw-py-2 tw-text-center tw-text-sm tw-font-medium tw-tracking-wide tw-text-white tw-transition hover:tw-opacity-75 focus-visible:tw-outline-2 focus-visible:tw-outline-offset-2 focus-visible:tw-outline-sky-700 active:tw-opacity-100 active:tw-outline-offset-0 disabled:tw-cursor-not-allowed disabled:tw-opacity-75 dark:tw-bg-sky-600 dark:tw-text-white dark:focus-visible:tw-outline-sky-600"
        >
            Message
        </button>

        <!-- Info Trigger -->
        <button
            x-on:click="$dispatch('notify', { variant: 'info', title: 'Update Available', message: 'A new version of the app is ready for you. Update now to enjoy the latest features!' })"
            type="button"
            class="tw-whitespace-nowrap tw-rounded-sm tw-bg-sky-700 tw-px-4 tw-py-2 tw-text-center tw-text-sm tw-font-medium tw-tracking-wide tw-text-slate-100 tw-transition hover:tw-opacity-75 focus-visible:tw-outline-2 focus-visible:tw-outline-offset-2 focus-visible:tw-outline-sky-700 active:tw-opacity-100 active:tw-outline-offset-0 disabled:tw-cursor-not-allowed disabled:tw-opacity-75"
        >
            Info
        </button>

        <!-- Success Trigger -->
        <button
            x-on:click="$dispatch('notify', { variant: 'success', title: 'Success!', message: 'Your changes have been saved. Keep up the great work!' })"
            type="button"
            class="tw-whitespace-nowrap tw-rounded-sm tw-bg-green-700 tw-px-4 tw-py-2 tw-text-center tw-text-sm tw-font-medium tw-tracking-wide tw-text-white tw-transition hover:tw-opacity-75 focus-visible:tw-outline-2 focus-visible:tw-outline-offset-2 focus-visible:tw-outline-green-700 active:tw-opacity-100 active:tw-outline-offset-0 disabled:tw-cursor-not-allowed disabled:tw-opacity-75"
        >
            Success
        </button>

        <!-- Danger Trigger -->
        <button
            x-on:click="$dispatch('notify', { variant: 'danger', title: 'Oops!', message: 'Something went wrong. Please try again. If the problem persists, we’re here to help!' })"
            type="button"
            class="tw-whitespace-nowrap tw-rounded-sm tw-bg-red-700 tw-px-4 tw-py-2 tw-text-center tw-text-sm tw-font-medium tw-tracking-wide tw-text-slate-100 tw-transition hover:tw-opacity-75 focus-visible:tw-outline-2 focus-visible:tw-outline-offset-2 focus-visible:tw-outline-red-700 active:tw-opacity-100 active:tw-outline-offset-0 disabled:tw-cursor-not-allowed disabled:tw-opacity-75"
        >
            Danger
        </button>

        <!-- Warning Trigger -->
        <button
            x-on:click="$dispatch('notify', { variant: 'warning', title: 'Action Needed', message: 'Your storage is getting low. Consider upgrading your plan.' })"
            type="button"
            class="tw-whitespace-nowrap tw-rounded-sm tw-bg-amber-600 tw-px-4 tw-py-2 tw-text-center tw-text-sm tw-font-medium tw-tracking-wide tw-text-amber-50 tw-transition hover:tw-opacity-75 focus-visible:tw-outline-2 focus-visible:tw-outline-offset-2 focus-visible:tw-outline-amber-600 active:tw-opacity-100 active:tw-outline-offset-0 disabled:tw-cursor-not-allowed disabled:tw-opacity-75"
        >
            Warning
        </button>
    </div>
    @endif

    <!-- Notifications -->
    <div
        x-data="{
			notifications: [],
			displayDuration: 8000,
			soundEffect: false,
			baseAudio: null,
			interactionBound: false,   // memastikan listener tidak dobel
			recoveryTimer: null,       // cek berkala untuk auto-recover
			
			addNotification({ variant = 'info', sender = null, title = null, message = null, duration = null }) {
				const id = Date.now()

                console.log('arguments', arguments)

				const notification = {
					id,
					variant,
					sender,
					title,
					message,
					duration: !isNaN(duration) ? +duration : this.displayDuration
				}

				console.log('Get new notification', notification)

				if (this.notifications.length >= 20) {
					this.notifications.splice(0, this.notifications.length - 19)
				}

				this.notifications.push(notification)

				if (this.soundEffect) {
					this.playSound()
				}
			},
			removeNotification(id) {
				setTimeout(() => {
					this.notifications = this.notifications.filter(n => n.id !== id)
				}, 400)
			},
			playSound() {
				const audio = this.baseAudio.cloneNode(true)

				audio.play().catch(err => {
					console.error('Sound error:', err)

					// Jika autoplay diblokir → pasang ulang listener
					if (err.name === 'NotAllowedError') {
						this.setupInteractionUnlock(true)
					}
				})
			},
			// AUTO FIX jika lost permission atau listener hilang
			setupInteractionUnlock(force = false) {
				if (this.interactionBound && !force) return

				console.warn('[AUDIO] Binding interaction unlock listener...')

				const unlock = () => {
					const a = this.baseAudio.cloneNode(true)
					a.volume = 0
					a.play().catch(_ => {})
					console.warn('[AUDIO] Unlocked by user interaction.')

					window.removeEventListener('click', unlock)
					this.interactionBound = false
				}

				this.interactionBound = true
				window.addEventListener('click', unlock)
			},
			init() {
                return;
				this.baseAudio = new Audio('{{ asset('assets/sounds/ding.mp3') }}')
				// this.baseAudio = new Audio('./src/sounds/ding.mp3')
				console.warn('Base audio loaded:', this.baseAudio)

				// pertama kali load → lock siap
				this.setupInteractionUnlock()

				// periodic worker: kadang JS clear listener → pasang ulang otomatis
				this.recoveryTimer = setInterval(() => {
					if (!this.interactionBound) {
						// Test apakah play masih forbidden
						const t = this.baseAudio.cloneNode(true)
						t.volume = 0
						t.play().catch(err => {
							if (err.name === 'NotAllowedError') {
								console.warn('[AUDIO] Autoplay lost → rebinding listener.')
								this.setupInteractionUnlock(true)
							}
						})
					}
				}, 2000)
			}
		}"
        x-on:notify.window="addNotification(Array.isArray($event.detail) ? $event.detail[0] : $event.detail)"
    >
        <!-- x-on:notify.window="addNotification({
            variant: $event.detail.variant,
            sender: $event.detail.sender,
            title: $event.detail.title,
            message: $event.detail.message,
            duration: $event.detail.duration,
        }); console.log('$event.detail', JSON.stringify($event.detail))" -->
        <div
            x-on:mouseenter="$dispatch('pause-auto-dismiss')"
            x-on:mouseleave="$dispatch('resume-auto-dismiss')"
            class="tw-group tw-pointer-events-none tw-fixed tw-inset-x-8 tw-top-0 tw-z-50 tw-flex tw-max-w-full tw-flex-col tw-gap-2 tw-bg-transparent tw-px-6 tw-py-6 md:tw-bottom-0 md:tw-left-[unset] md:tw-right-0 md:tw-top-[unset] md:tw-max-w-sm"
        >
            <template
                x-for="(notification, index) in notifications"
                x-bind:key="notification.id"
            >
                <div>
                    <!-- Generic Notification Template -->
                    <template
                        x-if="notification.variant === 'info' || notification.variant === 'success' || notification.variant === 'warning' || notification.variant === 'danger' || notification.variant === 'message'"
                    >
                        <div
                            x-data="{ isVisible: false, timeout: null }"
                            x-cloak
                            x-show="isVisible"
                            class="tw-pointer-events-auto tw-relative tw-rounded-sm tw-border tw-bg-zinc-50 tw-text-neutral-600 dark:tw-bg-zinc-900 dark:tw-text-zinc-200"
                            :class="{
                        'tw-border-sky-700': notification.variant === 'info',
                        'tw-border-green-700': notification.variant === 'success',
                        'tw-border-amber-600': notification.variant === 'warning',
                        'tw-border-red-700': notification.variant === 'danger',
                        'tw-border-zinc-300': notification.variant === 'message'
                    }"
                            role="alert"
                            x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                            x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id)}, displayDuration)"
                            x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id)}, displayDuration))"
                            x-transition:enter="tw-transition tw-duration-300 tw-ease-out"
                            x-transition:enter-start="tw-translate-y-8"
                            x-transition:enter-end="tw-translate-y-0"
                            x-transition:leave="tw-transition tw-duration-300 tw-ease-in"
                            x-transition:leave-start="tw-translate-x-0 tw-opacity-100"
                            x-transition:leave-end="-tw-translate-x-24 tw-opacity-0 md:tw-translate-x-24"
                        >
                            <div
                                class="tw-flex tw-w-full tw-items-center tw-gap-2.5 tw-rounded-sm tw-p-4 tw-transition-all tw-duration-300"
                                :class="{
                            'tw-bg-sky-700/10': notification.variant === 'info',
                            'tw-bg-green-700/10': notification.variant === 'success',
                            'tw-bg-amber-600/10': notification.variant === 'warning',
                            'tw-bg-red-700/10': notification.variant === 'danger',
                            'tw-bg-zinc-100 dark:tw-bg-zinc-800': notification.variant === 'message'
                        }"
                            >
                                <!-- Icon -->
                                <div
                                    class="tw-rounded-full tw-p-0.5"
                                    :class="{
                                'tw-bg-sky-700/15 tw-text-sky-700': notification.variant === 'info',
                                'tw-bg-green-700/15 tw-text-green-700': notification.variant === 'success',
                                'tw-bg-amber-600/15 tw-text-amber-600': notification.variant === 'warning',
                                'tw-bg-red-700/15 tw-text-red-700': notification.variant === 'danger',
                                'tw-bg-zinc-300 tw-text-neutral-600': notification.variant === 'message'
                            }"
                                    aria-hidden="true"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        class="tw-h-5 tw-w-5"
                                        aria-hidden="true"
                                    >
                                        <path
                                            x-show="notification.variant === 'info'"
                                            fill-rule="evenodd"
                                            d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                                            clip-rule="evenodd"
                                        />
                                        <path
                                            x-show="notification.variant === 'success'"
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                            clip-rule="evenodd"
                                        />
                                        <path
                                            x-show="notification.variant === 'warning' || notification.variant === 'danger'"
                                            fill-rule="evenodd"
                                            d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>

                                <!-- Content -->
                                <div
                                    class="tw-flex tw-flex-col tw-gap-2 tw-flex-1"
                                >
                                    <h3
                                        x-cloak
                                        x-show="notification.title"
                                        x-text="notification.title"
                                        class="tw-text-sm tw-font-semibold"
                                        :class="{
                                    'tw-text-sky-700': notification.variant === 'info',
                                    'tw-text-green-700': notification.variant === 'success',
                                    'tw-text-amber-600': notification.variant === 'warning',
                                    'tw-text-red-700': notification.variant === 'danger',
                                    'tw-text-neutral-900 dark:tw-text-zinc-50': notification.variant === 'message'
                                }"
                                    ></h3>
                                    <p
                                        x-cloak
                                        x-show="notification.message"
                                        x-text="notification.message"
                                        class="tw-text-sm"
                                    ></p>
                                </div>

                                <!-- Dismiss Button -->
                                <button
                                    type="button"
                                    class="tw-ml-auto"
                                    aria-label="dismiss notification"
                                    x-on:click="(isVisible = false), removeNotification(notification.id)"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-width="2"
                                        class="tw-h-5 tw-w-5"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>
