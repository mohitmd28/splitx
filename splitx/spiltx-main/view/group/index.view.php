@layout('default')

<!-- Breadcrumb Start -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <h2 class="font-semibold text-title-md2 text-black dark:text-white">All Groups</h2>

    <nav>
        <ol class="flex items-center gap-2">
            <li><a href="/dashboard">Dashboard /</a></li>
            <li class="text-primary">All Group</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<!-- ====== Table Section Start -->
<div class="flex flex-col gap-10">
    <div class="rounded-lg border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <?php if (($message = session()->get('success'))) : ?>
                <div class="mb-3 p-2 text-primary"><?= $message ?></div>
            <?php endif; ?>

            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-8">
                            Name
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Members
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Date
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($groups)) : ?>
                        <tr>
                            <td colspan="4" class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-8">
                                <p class="text-center">There are no Groups</p>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($groups as $group) : ?>
                            <tr>
                                <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-8">
                                    <h5 class="font-medium text-black dark:text-white">
                                        <?= htmlspecialchars($group->name) ?>
                                    </h5>
                                </td>
                                <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <h5 class="font-medium text-black dark:text-white">
                                        <?= $group->members ?>
                                    </h5>
                                </td>
                                <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p class="text-black dark:text-white">
                                        <?php
                                        $date = new DateTime($group->created_at);
                                        echo date_format($date, "F d, Y");
                                        ?>
                                    </p>
                                </td>
                                <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div class="flex items-center space-x-3.5">
                                        <a href="/groups/edit?id=<?= $group->id ?>" class="hover:text-primary">
                                            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                <path d="M2.97917 17.5H13.6042C14.2627 17.4981 14.8936 17.2351 15.3584 16.7685C15.8232 16.302 16.0839 15.6702 16.0833 15.0116V9.67291C16.0833 9.48505 16.0087 9.30489 15.8759 9.17205C15.743 9.03921 15.5629 8.96458 15.375 8.96458C15.1871 8.96458 15.007 9.03921 14.8741 9.17205C14.7413 9.30489 14.6667 9.48505 14.6667 9.67291V15.0116C14.6676 15.2946 14.5563 15.5663 14.3571 15.7672C14.1579 15.9681 13.8871 16.0818 13.6042 16.0833H2.97917C2.69624 16.0818 2.42547 15.9681 2.22627 15.7672C2.02707 15.5663 1.91573 15.2946 1.91667 15.0116V4.40504C1.91573 4.12211 2.02707 3.85036 2.22627 3.64944C2.42547 3.44852 2.69624 3.33483 2.97917 3.33333H8.29167C8.47953 3.33333 8.6597 3.2587 8.79253 3.12586C8.92537 2.99303 9 2.81286 9 2.625C9 2.43714 8.92537 2.25697 8.79253 2.12413C8.6597 1.99129 8.47953 1.91666 8.29167 1.91666H2.97917C2.32063 1.91854 1.68974 2.1816 1.22495 2.64812C0.760158 3.11464 0.499435 3.7465 0.500001 4.40504V15.0116C0.499435 15.6702 0.760158 16.302 1.22495 16.7685C1.68974 17.2351 2.32063 17.4981 2.97917 17.5Z" fill="" />
                                                <path d="M7.1973 7.96867L6.63843 10.5286C6.61313 10.6447 6.61745 10.7653 6.651 10.8793C6.68454 10.9933 6.74623 11.0971 6.83039 11.181C6.9157 11.2628 7.01947 11.3228 7.13291 11.356C7.24635 11.3891 7.36611 11.3945 7.48205 11.3715L10.0363 10.8112C10.1689 10.7821 10.2904 10.7155 10.3862 10.6193L16.842 4.1635C17.0393 3.96617 17.1959 3.7319 17.3027 3.47406C17.4095 3.21622 17.4645 2.93986 17.4645 2.66077C17.4645 2.38168 17.4095 2.10533 17.3027 1.84749C17.1959 1.58965 17.0393 1.35537 16.842 1.15804C16.4374 0.77139 15.8992 0.555618 15.3396 0.555618C14.7799 0.555618 14.2418 0.77139 13.8372 1.15804L7.39139 7.62017C7.29464 7.71534 7.22728 7.83631 7.1973 7.96867ZM14.8388 2.16033C14.9736 2.03123 15.153 1.95916 15.3396 1.95916C15.5262 1.95916 15.7056 2.03123 15.8404 2.16033C15.9714 2.29395 16.0448 2.47363 16.0448 2.66077C16.0448 2.84792 15.9714 3.0276 15.8404 3.16121L15.3396 3.662L14.338 2.66042L14.8388 2.16033ZM8.53464 8.47442L13.3329 3.66413L14.3246 4.66075L9.52418 9.47246L8.25272 9.75154L8.53464 8.47442Z" fill="" />
                                            </svg>
                                        </a>

                                        <button class="hover:text-primary" @click="
                                            if(confirm('Do you really want to delete?')){
                                                $refs.groupToDelete.value = '<?= $group->id ?>';
                                                $refs.groupDeleteForm.submit();
                                            }
                                        ">
                                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.1594L4.07852 15.4688C4.13477 16.6219 5.09102 17.5219 6.24414 17.5219H11.7004C12.8535 17.5219 13.8098 16.6219 13.866 15.4688L14.3441 6.13127C14.8785 5.90627 15.2441 5.3719 15.2441 4.78127V3.93752C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.0973C10.2379 1.74377 10.3504 1.85627 10.3504 1.9969V2.47502H7.70664V1.9969H7.67852ZM4.02227 3.96565C4.02227 3.85315 4.10664 3.74065 4.24727 3.74065H13.7535C13.866 3.74065 13.9785 3.82502 13.9785 3.96565V4.8094C13.9785 4.9219 13.8941 5.0344 13.7535 5.0344H4.24727C4.13477 5.0344 4.02227 4.95002 4.02227 4.8094V3.96565ZM11.7285 16.2563H6.27227C5.79414 16.2563 5.40039 15.8906 5.37227 15.3844L4.95039 6.2719H13.0785L12.6566 15.3844C12.6004 15.8625 12.2066 16.2563 11.7285 16.2563Z" fill="" />
                                                <path d="M9.00039 9.11255C8.66289 9.11255 8.35352 9.3938 8.35352 9.75942V13.3313C8.35352 13.6688 8.63477 13.9782 9.00039 13.9782C9.33789 13.9782 9.64727 13.6969 9.64727 13.3313V9.75942C9.64727 9.3938 9.33789 9.11255 9.00039 9.11255Z" fill="" />
                                                <path d="M11.2502 9.67504C10.8846 9.64692 10.6033 9.90004 10.5752 10.2657L10.4064 12.7407C10.3783 13.0782 10.6314 13.3875 10.9971 13.4157C11.0252 13.4157 11.0252 13.4157 11.0533 13.4157C11.3908 13.4157 11.6721 13.1625 11.6721 12.825L11.8408 10.35C11.8408 9.98442 11.5877 9.70317 11.2502 9.67504Z" fill="" />
                                                <path d="M6.72245 9.67504C6.38495 9.70317 6.1037 10.0125 6.13182 10.35L6.3287 12.825C6.35683 13.1625 6.63808 13.4157 6.94745 13.4157C6.97558 13.4157 6.97558 13.4157 7.0037 13.4157C7.3412 13.3875 7.62245 13.0782 7.59433 12.7407L7.39745 10.2657C7.39745 9.90004 7.08808 9.64692 6.72245 9.67504Z" fill="" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <ul class="flex justify-center gap-3 mb-2 pt-6">
                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                    <li><a class="border hover:text-primary p-1 rounded" href="/groups?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor; ?>
            </ul>

            <form method="post" x-ref="groupDeleteForm" action="/groups/delete" style="display: none;">
                <input type="hidden" name="id" x-ref="groupToDelete">
            </form>
        </div>
    </div>
</div>
<!-- ====== Table Section End -->