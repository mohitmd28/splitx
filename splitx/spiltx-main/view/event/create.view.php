@layout('default')

<!-- Breadcrumb Start -->
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Create Event
    </h2>

    <nav>
        <ol class="flex items-center gap-2">
            <li><a href="/dashboard" class="font-medium">Dashboard /</a></li>
            <li class="font-medium text-primary">Create Event</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<!-- ====== Form Layout Section Start -->
<div class="grid grid-cols-5 gap-8">
    <div class="col-span-5 xl:col-span-3">
        <div class="flex flex-col gap-9">
            <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <form action="/events" method="post">
                    <div class="p-6.5">

                        <?php require VIEW_DIR . '/event/_fields.view.php' ?>

                        <button class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray mt-8">
                            Create Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ====== Form Layout Section End -->