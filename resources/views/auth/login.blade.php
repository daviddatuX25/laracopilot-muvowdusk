<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory System</title>
    <script>
        // Initialize theme from localStorage or system preference
        const theme = localStorage.getItem('theme');
        if (theme === 'light') {
            document.documentElement.classList.add('light');
        } else if (theme === 'dark') {
            document.documentElement.classList.remove('light');
        } else if (window.matchMedia('(prefers-color-scheme: light)').matches) {
            document.documentElement.classList.add('light');
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Exo:100,400,700" rel="stylesheet">
    <style>
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-scroll {
            animation: scroll 25s linear infinite;

        }
        .marquee-container {
            overflow: hidden;
        }

        /* Grid background animation */
        @keyframes bg-scrolling-reverse {
            100% { background-position: 50px 50px; }
        }

        @keyframes bg-scrolling {
            0% { background-position: 50px 50px; }
        }

        body {
            background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAIAAACRXR/mAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAABnSURBVHja7M5RDYAwDEXRDgmvEocnlrQS2SwUFST9uEfBGWs9c97nbGtDcquqiKhOImLs/UpuzVzWEi1atGjRokWLFi1atGjRokWLFi1atGjRokWLFi1af7Ukz8xWp8z8AAAA//8DAJ4LoEAAlL1nAAAAAElFTkSuQmCC");
            background-repeat: repeat;
            background-position: 0 0;
            animation: bg-scrolling-reverse 0.92s infinite linear;
            background-color: #0a0a0a;
        }

        <!-- Primary gradient for hero sections -->
        .gradient-violet {
            background: linear-gradient(135deg, rgba(20, 10, 40, 0.9) 0%, rgba(30, 15, 50, 0.95) 100%);
        }

        /* Dark mode gradient for form section */
        html:not(.light) .gradient-violet {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.95) 0%, rgba(17, 24, 39, 1) 100%);
        }

        /* Light mode gradient for form section */
        html.light .gradient-violet {
            background: linear-gradient(135deg, rgba(243, 244, 246, 0.95) 0%, rgba(229, 231, 235, 1) 100%);
        }

        /* Accent color utilities */
        .accent-violet {
            color: #a855f7;
        }

        .border-accent {
            border-color: #a855f7 !important;
        }

        .bg-accent {
            background-color: #a855f7;
        }

        .hover-accent:hover {
            background-color: #9333ea;
        }

        /* Glass morphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Text shadows for better contrast on animated bg */
        .text-shadow {
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        /* Opacity transition for stacked sections */
        .fade-in-out {
            transition: opacity 0.5s ease-in-out;
        }

        .opacity-in {
            opacity: 1;
            pointer-events: auto;
        }

        .opacity-out {
            opacity: 0;
            pointer-events: none;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Spread animation for form background */
        @keyframes spread-vertical {
            from {
                clip-path: inset(50% 0 50% 0);
            }
            to {
                clip-path: inset(0 0 0 0);
            }
        }

        .animate-spread {
            animation: spread-vertical 0.5s ease-in-out forwards;
        }

        .hero-no-bg {
            background: transparent !important;
            border: none !important;
        }

        /* Hide scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Arrow animation */
        @keyframes bounce-down {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(8px); }
        }

        @keyframes bounce-up {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .animate-bounce-down {
            animation: bounce-down 1s infinite;
        }

        .animate-bounce-up {
            animation: bounce-up 1s infinite;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white overflow-x-hidden"
    x-data="{
        showRequestForm: false,
        requestType: '',
        fullName: '',
        contactNumber: '',
        userEmail: '',
        messengerId: '',
        fieldOfUse: '',
        customMessage: '',
        fieldOfUseNames: {
            'sari_sari': 'Sari-Sari Store',
            'mini_grocery': 'Mini Grocery',
            'clothing': 'Clothing Store',
            'restaurant': 'Restaurant / Food Business',
            'pharmacy': 'Pharmacy',
            'hardware': 'Hardware Store',
            'other': 'Other / Custom'
        },
        openRequestForm() {
            this.showRequestForm = true;
        },
        backToHero() {
            this.showRequestForm = false;
            this.resetForm();
        },
        resetForm() {
            this.fullName = '';
            this.contactNumber = '';
            this.userEmail = '';
            this.messengerId = '';
            this.fieldOfUse = '';
            this.requestType = '';
            this.customMessage = '';
        },
        sendRequest() {
            if (!this.fullName.trim()) {
                alert('Please enter your full name');
                return;
            }
            if (!this.contactNumber.trim()) {
                alert('Please enter your contact number');
                return;
            }
            if (!this.userEmail.trim() || !this.userEmail.includes('@')) {
                alert('Please enter a valid email address');
                return;
            }
            if (!this.fieldOfUse) {
                alert('Please select your business type');
                return;
            }
            if (!this.requestType) {
                alert('Please select a request type');
                return;
            }
            if (this.requestType === 'custom' && !this.customMessage.trim()) {
                alert('Please enter your custom message');
                return;
            }

            let subject = '';
            let body = '';
            const businessType = this.fieldOfUseNames[this.fieldOfUse] || this.fieldOfUse;

            if (this.requestType === 'starter') {
                subject = 'Request for Starter Plan';
                body = `Hello,\n\nI would like to request a Starter Plan for your Inventory Management System.\n\n--- CONTACT INFORMATION ---\nFull Name: ${this.fullName}\nBusiness Type: ${businessType}\nContact Number: ${this.contactNumber}\nEmail: ${this.userEmail}\nMessenger: ${this.messengerId || 'Not provided'}\n\nPlease let me know the next steps and pricing for the starter plan.\n\nThank you!`;
            } else if (this.requestType === 'additional') {
                subject = 'Request for Additional Inventory';
                body = `Hello,\n\nI would like to request access to an additional inventory in the system.\n\n--- CONTACT INFORMATION ---\nFull Name: ${this.fullName}\nBusiness Type: ${businessType}\nContact Number: ${this.contactNumber}\nEmail: ${this.userEmail}\nMessenger: ${this.messengerId || 'Not provided'}\n\nPlease let me know what information you need from me.\n\nThank you!`;
            } else if (this.requestType === 'custom') {
                subject = 'Custom Account Request';
                body = `Hello,\n\n${this.customMessage}\n\n--- CONTACT INFORMATION ---\nFull Name: ${this.fullName}\nBusiness Type: ${businessType}\nContact Number: ${this.contactNumber}\nEmail: ${this.userEmail}\nMessenger: ${this.messengerId || 'Not provided'}\n\nThank you!`;
            }

            const mailtoLink = `mailto:dxtechph@gmail.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
            window.location.href = mailtoLink;
            this.backToHero();
        }
    }">
    <!-- Features Marquee Header -->
    <div class="fixed top-0 left-0 right-0 z-40 glass border-b border-purple-500/30 py-7 flex items-center px-4">
        <div class="flex-1 marquee-container">
            <div class="animate-scroll flex gap-12 whitespace-nowrap">
                <span class="text-gray-900 dark:text-gray-100 font-semibold flex items-center gap-2">
                    <span class="text-2xl">📦</span> Product Management
                </span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold flex items-center gap-2">
                    <span class="text-2xl">✓</span> Real-time Stock Tracking
                </span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold flex items-center gap-2">
                    <span class="text-2xl">⚡</span> Barcode Scanning
                </span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold flex items-center gap-2">
                    <span class="text-2xl">🤝</span> Supplier Management
                </span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold flex items-center gap-2">
                    <span class="text-2xl">🔔</span> Smart Alerts
                </span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold flex items-center gap-2">
                    <span class="text-2xl">📊</span> Detailed Reports
                </span>
                <!-- Duplicate for seamless loop -->
                <span class="text-gray-900 dark:text-gray-100 font-semibold flex items-center gap-2">
                    <span class="text-2xl">📦</span> Product Management
                </span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold flex items-center gap-2">
                    <span class="text-2xl">✓</span> Real-time Stock Tracking
                </span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold flex items-center gap-2">
                    <span class="text-2xl">⚡</span> Barcode Scanning
                </span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold flex items-center gap-2">
                    <span class="text-2xl">🤝</span> Supplier Management
                </span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold flex items-center gap-2">
                    <span class="text-2xl">🔔</span> Smart Alerts
                </span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold flex items-center gap-2">
                    <span class="text-2xl">📊</span> Detailed Reports
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 flex items-center pt-20">
        <div class="max-w-7xl mx-auto w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <!-- Left: Login Section (40%) - Bigger -->
                <div class="lg:col-span-5 row-span-1 row-start-2 lg:row-span-1 lg:row-start-1 ">
                    <!-- Existing Customers -->
                    <div class="glass rounded-xl shadow-2xl p-8 sticky top-12 border border-purple-500/30 mt-5 lg:mt-0 bg-white dark:bg-gray-800">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center text-shadow">Existing Customers</h2>
                        <form class="space-y-6" action="{{ route('auth.login') }}" method="POST">
                            @csrf

                            @if ($errors->has('auth'))
                                <div class="rounded-md bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-500 p-4">
                                    <p class="text-sm font-medium text-red-700 dark:text-red-400">
                                        {{ $errors->first('auth') }}
                                    </p>
                                </div>
                            @endif

                            <div class="space-y-4">
                                <div>
                                    <label for="userid" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">User ID</label>
                                    <input
                                        id="userid"
                                        name="userid"
                                        type="text"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 placeholder-gray-400 dark:placeholder-gray-500"
                                        placeholder="Enter your user ID"
                                        value="{{ old('userid') }}"
                                    >
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 placeholder-gray-400 dark:placeholder-gray-500"
                                        placeholder="Enter your password"
                                    >
                                </div>
                            </div>

                            <button
                                type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition"
                            >
                                Sign in
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Hero & Form Section (60%) -->
                <div class="lg:col-span-7 row-span-1 row-start-1 lg:row-span-1 lg:row-start-1  relative min-h-[700px]">
                    <!-- Hero Section Container -->
                    <div
                        :class="showRequestForm ? 'opacity-out' : 'opacity-in'"
                        class="fade-in-out absolute inset-0 z-10"
                    >
                        <div class="hero-no-bg rounded-xl p-12 h-full flex flex-col justify-center">
                            <div class="text-center">
                                <div class="text-6xl mb-6">📦</div>
                                <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-4 text-shadow" style="font-family: 'Exo', sans-serif; letter-spacing: -1px;">Manage Your Inventory Now!</h1>
                                <p class="text-2xl text-gray-600 dark:text-gray-200 mb-8">Professional, Real-time Stock Management Solution</p>
                                <button
                                    @click="openRequestForm()"
                                    class="bg-purple-600 hover:bg-purple-700 text-white px-10 py-5 rounded-lg font-bold text-xl transition transform hover:scale-110 shadow-lg inline-block"
                                    style="font-family: 'Exo', sans-serif; font-weight: 700; letter-spacing: 0.5px;"
                                >
                                    📝 Request Account Access
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Request Form Section Container -->
                    <div
                        x-cloak
                        :class="showRequestForm ? 'opacity-in animate-spread' : 'opacity-out'"
                        class="fade-in-out absolute inset-0 z-20"
                        x-data="{ scrollState: 'top' }"
                    >
                        <div class="gradient-violet border border-purple-500/50 rounded-xl p-12 h-full flex flex-col relative">
                            <!-- Scroll Indicator Arrow - Bottom Right -->
                            <div x-show="scrollState === 'top'" class="absolute bottom-6 right-6 z-30 pointer-events-none">
                                <svg class="w-6 h-6 text-purple-500 dark:text-purple-400 animate-bounce-down" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                </svg>
                            </div>

                            <div class="shrink-0 mb-6 flex items-center justify-between">
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-white accent-violet">Request Account Access</h2>
                                <button
                                    @click="backToHero()"
                                    class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition text-2xl"
                                    title="Back to Home"
                                >
                                    ← Back
                                </button>
                            </div>

                            <!-- Scrollable Form Content -->
                            <div class="flex-1 overflow-y-auto no-scrollbar" @scroll="scrollState = $event.target.scrollTop > 0 ? 'scrolled' : 'top'">
                                <form class="space-y-4" @submit.prevent="sendRequest()">
                            <!-- Full Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
                                <input type="text" x-model="fullName" class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:outline-none focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 placeholder-gray-400 dark:placeholder-gray-500" placeholder="Your full name" required>
                            </div>

                            <!-- Contact Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Number *</label>
                                <input type="tel" x-model="contactNumber" class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:outline-none focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 placeholder-gray-400 dark:placeholder-gray-500" placeholder="09XX XXX XXXX" required>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                                <input type="email" x-model="userEmail" class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:outline-none focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 placeholder-gray-400 dark:placeholder-gray-500" placeholder="Your email address" required>
                            </div>

                            <!-- Messenger ID -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Messenger ID / Username</label>
                                <input type="text" x-model="messengerId" class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:outline-none focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 placeholder-gray-400 dark:placeholder-gray-500" placeholder="Your Facebook Messenger username or ID">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave blank to contact via email or phone</p>
                            </div>

                            <!-- Business Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Business Type / Field of Use *</label>
                                <select x-model="fieldOfUse" class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:outline-none focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400" required>
                                    <option value="">Select your business type...</option>
                                    <option value="sari_sari">Sari-Sari Store</option>
                                    <option value="mini_grocery">Mini Grocery</option>
                                    <option value="clothing">Clothing Store</option>
                                    <option value="restaurant">Restaurant / Food Business</option>
                                    <option value="pharmacy">Pharmacy</option>
                                    <option value="hardware">Hardware Store</option>
                                    <option value="other">Other / Custom</option>
                                </select>
                            </div>

                            <!-- Request Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Request Type *</label>
                                <select x-model="requestType" class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:outline-none focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400" required>
                                    <option value="">Select request type...</option>
                                    <option value="starter">Request for Starter Plan</option>
                                    <option value="additional">Request for Additional Inventory</option>
                                    <option value="custom">Custom Message</option>
                                </select>
                            </div>

                            <!-- Custom Message -->
                            <div x-show="requestType === 'custom'" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Your Message</label>
                                <textarea x-model="customMessage" rows="4" class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:outline-none focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 resize-none placeholder-gray-400 dark:placeholder-gray-500" placeholder="Tell us about your request..."></textarea>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3 pt-4">
                                <button
                                    type="button"
                                    @click="backToHero()"
                                    class="flex-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white px-4 py-2 rounded-lg font-medium transition"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="flex-1 bg-purple-600 hover:bg-purple-700 dark:bg-purple-600 dark:hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition"
                                >
                                    Send Request
                                </button>
                            </div>
                        </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-20 py-6 border-t border-purple-500/20 bg-white dark:bg-gray-800">
        <div class="max-w-6xl mx-auto px-6 text-center text-gray-600 dark:text-gray-400 text-sm">
            <p>Inventory Management System &copy; 2025</p>
        </div>
    </footer>
</body>
</html>
