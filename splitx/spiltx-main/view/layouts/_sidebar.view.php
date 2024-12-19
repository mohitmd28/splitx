<!-- ===== Sidebar Start ===== -->
<aside :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'" class="absolute left-0 top-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0" @click.outside="sidebarToggle = false">
    <!-- SIDEBAR HEADER -->
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
        <a href="/dashboard">
            <img src="/images/logo/logo.svg" alt="Logo" />
        </a>

        <button class="block lg:hidden" @click.stop="sidebarToggle = !sidebarToggle">
            <svg class="fill-current" width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z" fill="" />
            </svg>
        </button>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col h-full overflow-y-auto duration-300 ease-linear">
        <!-- Sidebar Menu -->
        <nav class="flex flex-col justify-between h-full mt-5 py-4 px-4 lg:mt-9 lg:px-6" x-data="{selected: $persist('Dashboard')}">
            <!-- Menu Group -->
            <div>
                <ul class="mb-6 flex flex-col gap-1.5">
                    <!-- Menu Item Dashboard -->
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4" href="/dashboard" :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Dashboard') || (page === 'index' || page === 'index') }">
                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.10322 0.956299H2.53135C1.5751 0.956299 0.787598 1.7438 0.787598 2.70005V6.27192C0.787598 7.22817 1.5751 8.01567 2.53135 8.01567H6.10322C7.05947 8.01567 7.84697 7.22817 7.84697 6.27192V2.72817C7.8751 1.7438 7.0876 0.956299 6.10322 0.956299ZM6.60947 6.30005C6.60947 6.5813 6.38447 6.8063 6.10322 6.8063H2.53135C2.2501 6.8063 2.0251 6.5813 2.0251 6.30005V2.72817C2.0251 2.44692 2.2501 2.22192 2.53135 2.22192H6.10322C6.38447 2.22192 6.60947 2.44692 6.60947 2.72817V6.30005Z" fill="" />
                                <path d="M15.4689 0.956299H11.8971C10.9408 0.956299 10.1533 1.7438 10.1533 2.70005V6.27192C10.1533 7.22817 10.9408 8.01567 11.8971 8.01567H15.4689C16.4252 8.01567 17.2127 7.22817 17.2127 6.27192V2.72817C17.2127 1.7438 16.4252 0.956299 15.4689 0.956299ZM15.9752 6.30005C15.9752 6.5813 15.7502 6.8063 15.4689 6.8063H11.8971C11.6158 6.8063 11.3908 6.5813 11.3908 6.30005V2.72817C11.3908 2.44692 11.6158 2.22192 11.8971 2.22192H15.4689C15.7502 2.22192 15.9752 2.44692 15.9752 2.72817V6.30005Z" fill="" />
                                <path d="M6.10322 9.92822H2.53135C1.5751 9.92822 0.787598 10.7157 0.787598 11.672V15.2438C0.787598 16.2001 1.5751 16.9876 2.53135 16.9876H6.10322C7.05947 16.9876 7.84697 16.2001 7.84697 15.2438V11.7001C7.8751 10.7157 7.0876 9.92822 6.10322 9.92822ZM6.60947 15.272C6.60947 15.5532 6.38447 15.7782 6.10322 15.7782H2.53135C2.2501 15.7782 2.0251 15.5532 2.0251 15.272V11.7001C2.0251 11.4188 2.2501 11.1938 2.53135 11.1938H6.10322C6.38447 11.1938 6.60947 11.4188 6.60947 11.7001V15.272Z" fill="" />
                                <path d="M15.4689 9.92822H11.8971C10.9408 9.92822 10.1533 10.7157 10.1533 11.672V15.2438C10.1533 16.2001 10.9408 16.9876 11.8971 16.9876H15.4689C16.4252 16.9876 17.2127 16.2001 17.2127 15.2438V11.7001C17.2127 10.7157 16.4252 9.92822 15.4689 9.92822ZM15.9752 15.272C15.9752 15.5532 15.7502 15.7782 15.4689 15.7782H11.8971C11.6158 15.7782 11.3908 15.5532 11.3908 15.272V11.7001C11.3908 11.4188 11.6158 11.1938 11.8971 11.1938H15.4689C15.7502 11.1938 15.9752 11.4188 15.9752 11.7001V15.272Z" fill="" />
                            </svg>

                            Dashboard
                        </a>
                    </li>
                    <!-- Menu Item Dashboard -->

                    <!-- Menu Item Groups -->
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4" href="#" @click="selected = (selected === 'Groups' ? '':'Groups')" :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Groups') || (page === 'groups' || page === 'createGroup') }">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M11.9537 9.1343C13.5625 9.1343 14.8669 7.87335 14.8669 6.30803C14.8669 4.74272 13.5625 3.48177 11.9537 3.48177C10.3449 3.48177 9.0405 4.74272 9.0405 6.30803C9.0405 7.87335 10.3449 9.1343 11.9537 9.1343ZM11.9537 4.48183C13.019 4.48183 13.8886 5.30797 13.8886 6.32977C13.8886 7.35158 13.019 8.17772 11.9537 8.17772C10.8884 8.17772 10.0188 7.35158 10.0188 6.32977C10.0188 5.30797 10.8884 4.48183 11.9537 4.48183Z" fill="white" />
                                <path d="M13.3668 10.1126H10.5406C8.21434 10.1126 6.32292 12.0258 6.32292 14.352V16.1565C6.32292 16.4174 6.54033 16.6565 6.82296 16.6565C7.10558 16.6565 7.32298 16.4392 7.32298 16.1565V14.352C7.32298 12.5693 8.7796 11.091 10.5841 11.091H13.3886C15.1713 11.091 16.6497 12.5476 16.6497 14.352V16.1565C16.6497 16.4174 16.867 16.6565 17.1497 16.6565C17.4323 16.6565 17.6497 16.4392 17.6497 16.1565V14.352C17.5845 12.0258 15.6931 10.1126 13.3668 10.1126Z" fill="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.350311 11.0301C0.350311 9.09708 1.91731 7.53008 3.85031 7.53008H6.46008C7.23833 7.53008 7.95856 7.78467 8.54009 8.21495C8.76207 8.3792 8.80887 8.69231 8.64462 8.91429C8.48037 9.13627 8.16727 9.18307 7.94529 9.01882C7.53005 8.71158 7.01699 8.53008 6.46008 8.53008H3.85031C2.4696 8.53008 1.35031 9.64936 1.35031 11.0301V13.0125C1.35031 13.2886 1.12645 13.5125 0.850311 13.5125C0.574169 13.5125 0.350311 13.2886 0.350311 13.0125V11.0301Z" fill="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.95477 2.34348C4.12878 2.34348 3.45918 3.01307 3.45918 3.83907C3.45918 4.66506 4.12878 5.33466 4.95477 5.33466C5.78076 5.33466 6.45036 4.66506 6.45036 3.83907C6.45036 3.01307 5.78076 2.34348 4.95477 2.34348ZM2.45918 3.83907C2.45918 2.46079 3.5765 1.34348 4.95477 1.34348C6.33305 1.34348 7.45036 2.46079 7.45036 3.83907C7.45036 5.21734 6.33305 6.33466 4.95477 6.33466C3.5765 6.33466 2.45918 5.21734 2.45918 3.83907Z" fill="white" />
                            </svg>

                            Groups

                            <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current" :class="{ 'rotate-180': (selected === 'Groups') }" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z" fill="" />
                            </svg>

                        </a>

                        <!-- Dropdown Menu Start -->
                        <div class="overflow-hidden" :class="(selected === 'Groups') ? 'block' :'hidden'">
                            <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white" href="/groups" :class="page === 'groups' && '!text-white'">All
                                        Groups</a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white" href="/groups/create" :class="page === 'createGroup' && '!text-white'">
                                        Create Group</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown Menu End -->
                    </li>
                    <!-- Menu Item Groups -->

                    <!-- Menu Item Events -->
                    <li>
                        <a class="event relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4" href="#" @click="selected = (selected === 'Events' ? '':'Events')" :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Events') || (page === 'events' || page === 'createEvent') }">
                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.7499 2.9812H14.2874V2.36245C14.2874 2.02495 14.0062 1.71558 13.6405 1.71558C13.2749 1.71558 12.9937 1.99683 12.9937 2.36245V2.9812H4.97803V2.36245C4.97803 2.02495 4.69678 1.71558 4.33115 1.71558C3.96553 1.71558 3.68428 1.99683 3.68428 2.36245V2.9812H2.2499C1.29365 2.9812 0.478027 3.7687 0.478027 4.75308V14.5406C0.478027 15.4968 1.26553 16.3125 2.2499 16.3125H15.7499C16.7062 16.3125 17.5218 15.525 17.5218 14.5406V4.72495C17.5218 3.7687 16.7062 2.9812 15.7499 2.9812ZM1.77178 8.21245H4.1624V10.9968H1.77178V8.21245ZM5.42803 8.21245H8.38115V10.9968H5.42803V8.21245ZM8.38115 12.2625V15.0187H5.42803V12.2625H8.38115ZM9.64678 12.2625H12.5999V15.0187H9.64678V12.2625ZM9.64678 10.9968V8.21245H12.5999V10.9968H9.64678ZM13.8374 8.21245H16.228V10.9968H13.8374V8.21245ZM2.2499 4.24683H3.7124V4.83745C3.7124 5.17495 3.99365 5.48433 4.35928 5.48433C4.7249 5.48433 5.00615 5.20308 5.00615 4.83745V4.24683H13.0499V4.83745C13.0499 5.17495 13.3312 5.48433 13.6968 5.48433C14.0624 5.48433 14.3437 5.20308 14.3437 4.83745V4.24683H15.7499C16.0312 4.24683 16.2562 4.47183 16.2562 4.75308V6.94683H1.77178V4.75308C1.77178 4.47183 1.96865 4.24683 2.2499 4.24683ZM1.77178 14.5125V12.2343H4.1624V14.9906H2.2499C1.96865 15.0187 1.77178 14.7937 1.77178 14.5125ZM15.7499 15.0187H13.8374V12.2625H16.228V14.5406C16.2562 14.7937 16.0312 15.0187 15.7499 15.0187Z" fill=""></path>
                            </svg>
                            Events

                            <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current" :class="{ 'rotate-180': (selected === 'Events') }" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z" fill="" />
                            </svg>

                        </a>

                        <!-- Dropdown Menu Start -->
                        <div class="overflow-hidden" :class="(selected === 'Events') ? 'block' :'hidden'">
                            <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                                <li>
                                    <a class="event relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white" href="/events" :class="page === 'events' && '!text-white'">All
                                        Events</a>
                                </li>
                                <li>
                                    <a class="evnet relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white" href="/events/create" :class="page === 'createEvent' && '!text-white'">
                                        Create Event</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown Menu End -->
                    </li>
                    <!-- Menu Item Events -->
                </ul>
            </div>

            <!-- Logout -->
            <div>

                <span class="block font-bold mb-3" style="text-transform: uppercase;">#<?= user()->code ?></span>

                <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4" href="/logout" :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Logout') || (page === 'login' || page === 'login') }">
                    <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5375 0.618744H11.6531C10.7594 0.618744 10.0031 1.37499 10.0031 2.26874V4.64062C10.0031 5.05312 10.3469 5.39687 10.7594 5.39687C11.1719 5.39687 11.55 5.05312 11.55 4.64062V2.23437C11.55 2.16562 11.5844 2.13124 11.6531 2.13124H15.5375C16.3625 2.13124 17.0156 2.78437 17.0156 3.60937V18.3562C17.0156 19.1812 16.3625 19.8344 15.5375 19.8344H11.6531C11.5844 19.8344 11.55 19.8 11.55 19.7312V17.3594C11.55 16.9469 11.2062 16.6031 10.7594 16.6031C10.3125 16.6031 10.0031 16.9469 10.0031 17.3594V19.7312C10.0031 20.625 10.7594 21.3812 11.6531 21.3812H15.5375C17.2219 21.3812 18.5625 20.0062 18.5625 18.3562V3.64374C18.5625 1.95937 17.1875 0.618744 15.5375 0.618744Z" fill=""></path>
                        <path d="M6.05001 11.7563H12.2031C12.6156 11.7563 12.9594 11.4125 12.9594 11C12.9594 10.5875 12.6156 10.2438 12.2031 10.2438H6.08439L8.21564 8.07813C8.52501 7.76875 8.52501 7.2875 8.21564 6.97812C7.90626 6.66875 7.42501 6.66875 7.11564 6.97812L3.67814 10.4844C3.36876 10.7938 3.36876 11.275 3.67814 11.5844L7.11564 15.0906C7.25314 15.2281 7.45939 15.3312 7.66564 15.3312C7.87189 15.3312 8.04376 15.2625 8.21564 15.125C8.52501 14.8156 8.52501 14.3344 8.21564 14.025L6.05001 11.7563Z" fill=""></path>
                    </svg>

                    Log Out
                </a>
            </div>
        </nav>
        <!-- Sidebar Menu -->

    </div>
</aside>
<!-- ===== Sidebar End ===== -->