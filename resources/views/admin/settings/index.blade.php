<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('General Settings') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-2xl mx-auto">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-6">
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" name="company_name" id="company_name" value="{{ $settings['company_name'] ?? 'Procurement MIS' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Current Logo</label>
                    <div class="mt-2 flex items-center">
                        @if(isset($settings['company_logo']))
                            <img src="{{ Storage::url($settings['company_logo']) }}" alt="Company Logo" class="h-16 w-auto object-contain border p-1 rounded">
                        @else
                            <div class="h-16 w-16 bg-gray-100 flex items-center justify-center text-xs text-gray-400 border rounded">
                                No Logo
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <label for="company_logo" class="block text-sm font-medium text-gray-700">Upload New Logo</label>
                    <input type="file" name="company_logo" id="company_logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-500 mt-1">Recommended size: 200x50px. Max 2MB.</p>
                </div>

                <hr class="my-6 border-gray-200">

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Current Favicon</label>
                    <div class="mt-2 flex items-center">
                        @if(isset($settings['site_favicon']))
                            <img src="{{ Storage::url($settings['site_favicon']) }}" alt="Site Favicon" class="h-8 w-8 object-contain border p-1 rounded">
                        @else
                            <div class="h-8 w-8 bg-gray-100 flex items-center justify-center text-xs text-gray-400 border rounded">
                                None
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <label for="site_favicon" class="block text-sm font-medium text-gray-700">Upload New Favicon</label>
                    <input type="file" name="site_favicon" id="site_favicon" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-500 mt-1">Recommended size: 32x32px or 16x16px (PNG/ICO). Max 1MB.</p>
                </div>

                <hr class="my-6 border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">System Announcement</h3>

                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="show_announcement" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ isset($settings['show_announcement']) && $settings['show_announcement'] ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">Show Announcement Modal on Login</span>
                    </label>
                </div>

                <div class="mb-4">
                    <label for="announcement_title" class="block text-sm font-medium text-gray-700">Announcement Title</label>
                    <input type="text" name="announcement_title" id="announcement_title" value="{{ $settings['announcement_title'] ?? 'Welcome to Procurement MIS' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="announcement_body" class="block text-sm font-medium text-gray-700">Announcement Body (HTML supported)</label>
                    <textarea name="announcement_body" id="announcement_body" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings['announcement_body'] ?? '' }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="announcement_version" class="block text-sm font-medium text-gray-700">Announcement Version</label>
                    <div class="flex items-center">
                        <input type="text" name="announcement_version" id="announcement_version" value="{{ $settings['announcement_version'] ?? '1.0' }}" class="mt-1 block w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <span class="ml-3 text-xs text-gray-500">Change this number (e.g., 1.1) to force the modal to appear again for all users.</span>
                    </div>
                </div>

                <hr class="my-6 border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Email & Notification Settings</h3>

                <div class="mb-6">
                    <label for="manager_notification_email" class="block text-sm font-medium text-gray-700">Manager Email for Notifications</label>
                    <input type="email" name="manager_notification_email" id="manager_notification_email" value="{{ $settings['manager_notification_email'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="manager@nsdo.org.af">
                    <p class="text-xs text-gray-500 mt-1">This email will receive alerts when reports are exported.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="mail_host" class="block text-sm font-medium text-gray-700">SMTP Host</label>
                        <input type="text" name="mail_host" id="mail_host" value="{{ $settings['mail_host'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="smtp.gmail.com">
                    </div>
                    <div>
                        <label for="mail_port" class="block text-sm font-medium text-gray-700">SMTP Port</label>
                        <input type="text" name="mail_port" id="mail_port" value="{{ $settings['mail_port'] ?? '587' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="mail_username" class="block text-sm font-medium text-gray-700">SMTP Username</label>
                        <input type="text" name="mail_username" id="mail_username" value="{{ $settings['mail_username'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="mail_password" class="block text-sm font-medium text-gray-700">SMTP Password</label>
                        <input type="password" name="mail_password" id="mail_password" value="{{ $settings['mail_password'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="mail_encryption" class="block text-sm font-medium text-gray-700">Encryption (tls/ssl)</label>
                        <input type="text" name="mail_encryption" id="mail_encryption" value="{{ $settings['mail_encryption'] ?? 'tls' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="mail_from_address" class="block text-sm font-medium text-gray-700">From Email Address</label>
                        <input type="email" name="mail_from_address" id="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <label for="mail_from_name" class="block text-sm font-medium text-gray-700">From Name</label>
                    <input type="text" name="mail_from_name" id="mail_from_name" value="{{ $settings['mail_from_name'] ?? 'Procurement MIS' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
