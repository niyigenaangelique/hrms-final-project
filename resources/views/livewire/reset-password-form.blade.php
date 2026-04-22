<div class="min-h-screen bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center px-4 py-8">
    <div
        class="w-full max-w-7xl mx-auto bg-white shadow-2xl rounded-xl overflow-hidden grid grid-cols-1 md:grid-cols-3">
        {{-- Left Side: Reset Password Form --}}
        <div class="bg-white max-w-2xl p-12 flex flex-col justify-center md:col-span-1">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-primary-900">
                    Create New Password
                </h2>
                <p class="text-gray-600 mt-2">
                    Please enter your new password below.
                </p>
            </div>

            <form
                wire:submit="submit"
                class="space-y-6"
                novalidate
            >
                @csrf
                <input type="hidden" wire:model="token">

                {{-- Status Handling --}}
                @if ($status)
                    <div id="alert-border-3" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50" role="alert">
                        <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="ms-3 text-sm font-medium">
                            {{ $status }}
                        </div>
                    </div>
                @endif

                {{-- Input Fields --}}
                <div class="space-y-4">
                    <flux:input
                        wire:model="email"
                        label="Email Address"
                        type="email"
                        required
                        readonly
                        class="w-full bg-gray-50 text-gray-500"
                    />

                    <flux:input
                        wire:model="password"
                        type="password"
                        label="New Password"
                        placeholder="Enter your new password"
                        required
                        :error="$errors->first('password')"
                        class="w-full"
                        viewable
                    />

                    <flux:input
                        wire:model="password_confirmation"
                        type="password"
                        label="Confirm Password"
                        placeholder="Confirm your new password"
                        required
                        :error="$errors->first('password_confirmation')"
                        class="w-full"
                        viewable
                    />
                </div>

                {{-- Submit Button --}}
                <div class="mt-6 flex flex-col space-y-4">
                    <flux:button type="submit" variant="primary" class="w-full">
                        Reset Password
                    </flux:button>
                </div>
            </form>
        </div>


        {{-- Right Side: Features Section --}}
        <div
            class="hidden md:block bg-cover bg-center relative md:col-span-2"
            style="background-image: url('{{ asset('images/bg001.png') }}')"
        >
            <div class="absolute inset-0 bg-primary-900/70"></div>
            <div class="relative z-10 flex flex-col justify-center h-full p-12 text-white">
                <h2 class="text-4xl font-bold mb-6">
                    TalentFlowPro- HRMS
                    Features
                </h2>
                <p class="text-xl mb-8 leading-relaxed">
                    Our HRMS empowers organizations to streamline HR operations across multiple projects with a unified
                    and efficient platform.
                </p>

                <ul class="grid grid-cols-1 gap-2 mb-8">
                    <li class="flex items-center bg-white/10 p-4 rounded-lg transition-all duration-300 hover:bg-opacity-20 hover:shadow-md">
                        <div class="bg-blue-100 text-blue-600 rounded-full p-3 mr-4 shadow-md">
                            <flux:icon.shield-check variant="solid"/>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-lg">Secure Access</h3>
                            <p class="text-white/80 text-sm">
                                Best-in-class security standards to protect your data.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
