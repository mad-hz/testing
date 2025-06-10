<x-layouts.app>
    <main class="flex min-h-full items-center px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto flex max-w-5xl items-center gap-x-16">
            <div class="max-w-xl">
                <p class="text-base font-semibold">403 - Forbidden</p>
                <h1 class="mt-4 text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl">
                    Access Denied
                </h1>
                <p class="mt-6 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">
                    You do not have permission to view this page. The server is refusing to fulfill your request due to access restrictions.
                </p>
                <p class="mt-6 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">
                    This could be because you do not have the required role or permissions for this page, or it might be restricted for certain users.
                </p>
                <p class="mt-6 font-medium text-pretty text-gray-500">Here are some things you can try:
                <ul class="list-disc mt-3 font-medium text-pretty text-gray-500 text-md ml-5">
                    <li>
                        Ensure that you have the correct permissions or role to access this page.
                    </li>
                    <li>
                        If you believe you should have access, contact the support team for assistance.
                    </li>
                    <li>
                        If your role has changed recently, log out and log back in to refresh your access.
                    </li>
                </ul>
                </p>
                <div class="mt-10 flex items-center gap-x-6">
                    <a href="{{ route('dashboard') }}"
                        class="rounded-md bg-red-700 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs">
                        Go back home
                    </a>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>
