<?php

namespace Views;

class ViewLayout extends ViewsBase
{
    private $userName = '';
    private $roleName = '';
    private $role = 0;
    private $page = '';

    function setRole($userName, $role)
    {
        $this->userName = $userName;
        $this->role = $role;
        if ($role == 0) {
            $this->roleName = 'Student';
        } else if ($role == 1) {
            $this->roleName = 'Teacher';
        } else if ($role == 2) {
            $this->roleName = 'Admin';
        }
    }

    function setPage($page)
    {
        $this->page = $page;
    }

    function setTitle($title)
    {
        $this->title = $title;
    }

    function addCSS($css)
    {
        $this->arrCSS[] = $css;
    }

    function addJS($js)
    {
        $this->arrJS[] = $js;
    }

    public function renderMenu()
    {
        $menus = [];
        if ($this->role == 0) {
            $menus = $this->menuStudent();
        } else if ($this->role == 1) {
            $menus = $this->menuTeacher();
        } else if ($this->role == 2) {
            $menus = $this->menuAdmin();
        } else {
            $menus = [];
        }

        foreach ($menus as $menu) {
?>
            <li><a href="<?= $menu['link'] ?>" class="<?= $this->page == $menu['name'] ? 'active' : '' ?>">
                    <span>
                    <?= $menu['svg'] ?>
                    </span>
                    <span><?= $menu['name'] ?></span>
                </a>
            </li>
<?php
        }
    }
    // 0: student; 1: teacher; 2: admin
    private function renderRoot() {}

    private function menuStudent()
    {
        return [
            [
                'name' => 'Dashboard',
                'svg' => 'speedometer',
                'link' => 'dashboard'
            ],
            [
                'name' => 'Classes',
                'svg' => 'student_2_',
                'link' => 'classes'
            ],
            [
                'name' => 'My Profile',
                'svg' => 'user',
                'link' => 'profile'
            ],
            [
                'name' => 'Log Out',
                'svg' => 'power-button',
                'link' => 'logout'
            ]
        ];
    }

    private function menuTeacher()
    {
        return [
            [
                'name' => 'Dashboard',
                'svg' => 'speedometer',
                'link' => 'dashboard'
            ],
            [
                'name' => 'Classes',
                'svg' => 'student_2_',
                'link' => 'classes'
            ],
            [
                'name' => 'My Profile',
                'svg' => 'user',
                'link' => 'profile'
            ],
            [
                'name' => 'Log Out',
                'svg' => 'power-button',
                'link' => 'logout'
            ]
        ];
    }

    private function menuAdmin()
    {
        return [
            [
                'name' => 'Dashboard',
                'svg' => file_get_contents("public/svgs/dashboard.svg"),
                'link' => 'dashboard'
            ],
            [
                'name' => 'Classes',
                'svg' => file_get_contents("public/svgs/class.svg"),
                'link' => 'classes'
            ],
            [
                'name' => 'Course',
                'svg' => file_get_contents("public/svgs/class.svg"),
                'link' => 'classes'
            ],
            [
                'name' => 'My Profile',
                'svg' => file_get_contents("public/svgs/person.svg"),
                'link' => 'profile'
            ],
            [
                'name' => 'Log Out',
                'svg' => file_get_contents("public/svgs/logout.svg"),
                'link' => 'logout'
            ]
        ];
    }



    function renderBody()
    {
        ?>

        <header class="w-full h-[50px] fixed top-0 left-0 right-0 border-b-[1px] bg-white">
            <div class="max-w-[100%] mx-auto h-full px-[10px] lg:px-[25px]">
                <div class="flex h-full justify-between">
                    <div class="py-[2px]"><img class="h-full" src="public/img/LogoMrBien-_banner@2x-1.png" alt=""></div>
                    <label for="check-notif" class="header_notif flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                        </svg>
                        <div class="header_quantity-notif"> <span>2</span> </div>
                        <input type="checkbox" class="check-notif" id="check-notif" hidden>
                        <label for="check-notif" class="overllay-notif"></label>
                        <div class="header_notif_contents">
                            <ul>
                                <li><a href="#">Thông Báo 1 thong bao 2 thong bao 3</a></li>
                                <li><a class="noread" href="#">Thông Báo 1</a></li>
                            </ul>
                        </div>
                    </label>
                </div>
            </div>
        </header>

        <div class="mt-[50px] max-w-[100%] mx-auto">
            <div class="flex flex-col md:flex-row">
                <aside class="aside header_aside lg:w-[250px] md:w-[200px] p-[10px] md:p-[0px] flex justify-between items-center md:items-stretch border-[1px]">
                    <div class="md:w-full">
                        <div class="flex flex-col justify-center items-center md:mt-[15px]">
                            <h3 class="font-bold"><?= $this->userName ?></h3>
                            <span class="text-[12px]"><?= $this->roleName ?></span>
                        </div>
                        <input class="check-menu" id="check-menu" type="checkbox" hidden>
                        <label for="check-menu" class="overllay"></label>
                        <div class="menu">
                            <label for="check-menu" class="md:hidden close">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </label>
                            <p class="block md:hidden text-center m-0 p-[8px] text-[20px] font-medium">MENU</p>
                            <ul class="list-ul">
                                <?= $this->renderMenu() ?>
                            </ul>
                        </div>
                    </div>
                    <label for="check-menu" class="block md:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </label>
                </aside>
                <main class="main flex-1 py-0 px-[0px] md:p-[0px]">
                    <div id="root">
                        <?= $this->renderRoot() ?>
                    </div>
                </main>
            </div>
        </div>

<?Php
    }
}
