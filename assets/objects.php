<?php
    /*
    * Wechslerein
    *
    * (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
    *
    * This source file is subject to the MIT license that is bundled
    * with this source code in the file LICENSE.
    */

    function printNavBarDesktop(): void
    {
        //print navbar with the banner at the left and a Account and settings button at the right
        echo '<div class="navbar">
                    <div class="navbar-left">
                        <div class="navbar-item">
                            <a href="/app/">
                                <img src="/assets/media/banner.png" alt="Wechslerein Logo" class="navbar-logo">
                            </a>
                        </div>
                        <div class="navbar-item">
                            <a href="javascript:location.reload()">
                                <i class="fa-solid fa-sync"> ' . languageAPI::getPhrase(".refresh") . '</i>
                            </a>
                        </div>
                    </div>
                    <div class="navbar-right">
                        <div class="navbar-item">
                            <a href="/app/">
                                <i class="fa-solid fa-house"> ' . languageAPI::getPhrase(".home") . '</i>
                            </a>
                        </div>
                        <div class="navbar-item">
                            <a href="/app/settings/">
                                <i class="fa-solid fa-gear"> ' . languageAPI::getPhrase(".settings") . '</i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <style>
                    .navbar {
                        display: flex;
                        flex-direction: row;
                        justify-content: space-between;
                        align-items: center;
                        height: 60px;
                        background-color: #fcfcfc;
                        color: white;
                        padding: 0 20px;
                        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2);
                    }
                
                    .navbar-left {
                        display: flex;
                        flex-direction: row;
                        justify-content: flex-start;
                        align-items: center;
                    }
                
                    .navbar-right {
                        display: flex;
                        flex-direction: row;
                        justify-content: flex-end;
                        align-items: center;
                    }
                
                    .navbar-item {
                        margin: 0 10px;
                    }
                
                    .navbar-logo {
                        height: 30px;
                    }
                
                    .navbar-icon {
                        height: 60px;
                    }
                    
                    .navbar-item a {
                        text-decoration: none;
                        color: #66e47e;
                    }
                    
                    .navbar-item a:hover {
                        color: #fcfcfc;
                    }
                </style>
                ';
    }

    function printAlert($type, $message): void
    {
        echo '<div class="alert" id="' . $type . '">
                    <span class="alert-close" onclick="this.parentElement.style.display=\'none\';"><i class="fa-solid fa-xmark"></i></span> 
                    <p>' . $message . '</p>
                   </div>';
    }