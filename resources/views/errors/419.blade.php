@extends('layouts.errors')

@section('title', '419 Session Expired')

@section('content')
    <section class="h-dvh flex items-center justify-center bg-white dark:bg-gray-900">
        <div>
            <svg class="animated w-96 text-blue-600"
                 id="freepik_stories-time-management"
                 xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 500 500"
                 version="1.1"
                 xmlns:xlink="http://www.w3.org/1999/xlink"
                 xmlns:svgjs="http://svgjs.com/svgjs">
                <style>
                    svg#freepik_stories-time-management:not(.animated) .animable {
                        opacity: 0;
                    }

                    svg#freepik_stories-time-management.animated #freepik--background-complete--inject-135 {
                        animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) lightSpeedRight;
                        animation-delay: 0s;
                    }

                    svg#freepik_stories-time-management.animated #freepik--Shadow--inject-135 {
                        animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) zoomOut;
                        animation-delay: 0s;
                    }

                    svg#freepik_stories-time-management.animated #freepik--Hourglass--inject-135 {
                        animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) lightSpeedRight, 1.5s Infinite linear floating;
                        animation-delay: 0s, 1s;
                    }

                    svg#freepik_stories-time-management.animated #freepik--Character--inject-135 {
                        animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) zoomOut;
                        animation-delay: 0s;
                    }

                    svg#freepik_stories-time-management.animated #freepik--Clock--inject-135 {
                        animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) fadeIn, 1.5s Infinite linear heartbeat;
                        animation-delay: 0s, 1s;
                    }

                    @keyframes lightSpeedRight {
                        from {
                            transform: translate3d(50%, 0, 0) skewX(-20deg);
                            opacity: 0;
                        }

                        60% {
                            transform: skewX(10deg);
                            opacity: 1;
                        }

                        80% {
                            transform: skewX(-2deg);
                        }

                        to {
                            opacity: 1;
                            transform: translate3d(0, 0, 0);
                        }
                    }

                    @keyframes zoomOut {
                        0% {
                            opacity: 0;
                            transform: scale(1.5);
                        }

                        100% {
                            opacity: 1;
                            transform: scale(1);
                        }
                    }

                    @keyframes floating {
                        0% {
                            opacity: 1;
                            transform: translateY(0px);
                        }

                        50% {
                            transform: translateY(-10px);
                        }

                        100% {
                            opacity: 1;
                            transform: translateY(0px);
                        }
                    }

                    @keyframes fadeIn {
                        0% {
                            opacity: 0;
                        }

                        100% {
                            opacity: 1;
                        }
                    }

                    @keyframes heartbeat {
                        0% {
                            transform: scale(1);
                        }

                        10% {
                            transform: scale(1.1);
                        }

                        30% {
                            transform: scale(1);
                        }

                        40% {
                            transform: scale(1);
                        }

                        50% {
                            transform: scale(1.1);
                        }

                        60% {
                            transform: scale(1);
                        }

                        100% {
                            transform: scale(1);
                        }
                    }
                </style>
                <g class="animable"
                   id="freepik--background-complete--inject-135"
                   style="transform-origin: 250px 228.23px;">
                    <rect class="animable"
                          id="elez4f3wkfgkt"
                          style="fill: rgb(235, 235, 235); transform-origin: 250px 382.525px;"
                          y="382.4"
                          width="500"
                          height="0.25"></rect>
                    <rect class="animable"
                          id="elpsrugpwadd"
                          style="fill: rgb(235, 235, 235); transform-origin: 433.34px 398.615px;"
                          x="416.78"
                          y="398.49"
                          width="33.12"
                          height="0.25"></rect>
                    <rect class="animable"
                          id="eluts1lm342yb"
                          style="fill: rgb(235, 235, 235); transform-origin: 326.875px 401.335px;"
                          x="322.53"
                          y="401.21"
                          width="8.69"
                          height="0.25"></rect>
                    <rect class="animable"
                          id="elh202bj3d0ln"
                          style="fill: rgb(235, 235, 235); transform-origin: 406.185px 389.335px;"
                          x="396.59"
                          y="389.21"
                          width="19.19"
                          height="0.25"></rect>
                    <rect class="animable"
                          id="eld75ac2nna4"
                          style="fill: rgb(235, 235, 235); transform-origin: 74.055px 391.015px;"
                          x="52.46"
                          y="390.89"
                          width="43.19"
                          height="0.25"></rect>
                    <rect class="animable"
                          id="el4hwvbhub7h6"
                          style="fill: rgb(235, 235, 235); transform-origin: 107.725px 391.015px;"
                          x="104.56"
                          y="390.89"
                          width="6.33"
                          height="0.25"></rect>
                    <rect class="animable"
                          id="elxbxtbljatp"
                          style="fill: rgb(235, 235, 235); transform-origin: 178.31px 395.235px;"
                          x="131.47"
                          y="395.11"
                          width="93.68"
                          height="0.25"></rect>
                    <path class="animable"
                          id="elx77y41ipwt"
                          style="fill: rgb(235, 235, 235); transform-origin: 140.46px 196.4px;"
                          d="M237,337.8H43.91a5.71,5.71,0,0,1-5.7-5.71V60.66A5.71,5.71,0,0,1,43.91,55H237a5.71,5.71,0,0,1,5.71,5.71V332.09A5.71,5.71,0,0,1,237,337.8ZM43.91,55.2a5.46,5.46,0,0,0-5.45,5.46V332.09a5.46,5.46,0,0,0,5.45,5.46H237a5.47,5.47,0,0,0,5.46-5.46V60.66A5.47,5.47,0,0,0,237,55.2Z">
                    </path>
                    <path class="animable"
                          id="elsla3vxhiwds"
                          style="fill: rgb(235, 235, 235); transform-origin: 356.75px 196.4px;"
                          d="M453.31,337.8H260.21a5.72,5.72,0,0,1-5.71-5.71V60.66A5.72,5.72,0,0,1,260.21,55h193.1A5.71,5.71,0,0,1,459,60.66V332.09A5.71,5.71,0,0,1,453.31,337.8ZM260.21,55.2a5.47,5.47,0,0,0-5.46,5.46V332.09a5.47,5.47,0,0,0,5.46,5.46h193.1a5.47,5.47,0,0,0,5.46-5.46V60.66a5.47,5.47,0,0,0-5.46-5.46Z">
                    </path>
                    <g id="el69eui176sq3">
                        <rect class="animable"
                              id="elmudb9z6gg8n"
                              style="fill: rgb(230, 230, 230); transform-origin: 134.65px 239.005px; transform: rotate(180deg);"
                              x="66.8"
                              y="95.61"
                              width="135.7"
                              height="286.79"></rect>
                    </g>
                    <g id="elmv97twsl97">
                        <rect class="animable"
                              id="el4j5dc92ma73"
                              style="fill: rgb(245, 245, 245); transform-origin: 131.63px 239.005px; transform: rotate(180deg);"
                              x="63.78"
                              y="95.61"
                              width="135.7"
                              height="286.79"></rect>
                    </g>
                    <g id="el9oa6niwprx8">
                        <rect class="animable"
                              id="elbt7kpeydl3j"
                              style="fill: rgb(250, 250, 250); transform-origin: 131.635px 239.005px; transform: rotate(90deg);"
                              x="-5.68"
                              y="176.57"
                              width="274.63"
                              height="124.87"></rect>
                    </g>
                    <polygon class="animable"
                             id="ely9ao5t73fjp"
                             style="fill: rgb(255, 255, 255); transform-origin: 131.63px 239.005px;"
                             points="165.31 376.32 133.67 101.69 97.95 101.69 129.59 376.32 165.31 376.32"></polygon>
                    <g id="elvv5zwvae0jf">
                        <rect class="animable"
                              id="elf7mux2efc9a"
                              style="fill: rgb(230, 230, 230); transform-origin: 70.335px 239px; transform: rotate(90deg);"
                              x="-66.98"
                              y="237.86"
                              width="274.63"
                              height="2.28"></rect>
                    </g>
                    <g id="elz74ks2b9npa">
                        <rect class="animable"
                              id="elekug1u4i76d"
                              style="fill: rgb(245, 245, 245); transform-origin: 131.63px 129.56px; transform: rotate(180deg);"
                              x="66.02"
                              y="125.48"
                              width="131.22"
                              height="8.16"></rect>
                    </g>
                    <g id="el7pszwuafpev">
                        <rect class="animable"
                              id="elxf1kaw46ts9"
                              style="fill: rgb(240, 240, 240); transform-origin: 246.83px 299.195px; transform: rotate(90deg);"
                              x="163.63"
                              y="271.8"
                              width="166.4"
                              height="54.79"></rect>
                    </g>
                    <g id="elm130ja27rxq">
                        <rect class="animable"
                              id="ellirk40nm07"
                              style="fill: rgb(245, 245, 245); transform-origin: 246.825px 245.245px; transform: rotate(90deg);"
                              x="222.44"
                              y="220.86"
                              width="48.77"
                              height="48.77"></rect>
                    </g>
                    <g id="elyxb7b7u0cqd">
                        <rect class="animable"
                              id="elkx57v9uiop"
                              style="fill: rgb(245, 245, 245); transform-origin: 246.825px 298.395px; transform: rotate(90deg);"
                              x="222.44"
                              y="274.01"
                              width="48.77"
                              height="48.77"></rect>
                    </g>
                    <g id="elb0zoiyct51g">
                        <rect class="animable"
                              id="elao650a3otbs"
                              style="fill: rgb(245, 245, 245); transform-origin: 246.825px 351.555px; transform: rotate(90deg);"
                              x="222.44"
                              y="327.17"
                              width="48.77"
                              height="48.77"></rect>
                    </g>
                    <path class="animable"
                          id="ell1hv2xm9ak"
                          style="fill: rgb(230, 230, 230); transform-origin: 246.815px 222.745px;"
                          d="M257.63,220.22H236a5,5,0,0,0,5.05,5.05h11.48A5.06,5.06,0,0,0,257.63,220.22Z"></path>
                    <path class="animable"
                          id="elbzx2nqennsh"
                          style="fill: rgb(230, 230, 230); transform-origin: 246.815px 275.9px;"
                          d="M257.63,273.37H236a5.06,5.06,0,0,0,5.05,5.06h11.48A5.07,5.07,0,0,0,257.63,273.37Z"></path>
                    <path class="animable"
                          id="eli7x00tyta8"
                          style="fill: rgb(230, 230, 230); transform-origin: 246.815px 329.05px;"
                          d="M257.63,326.52H236a5.06,5.06,0,0,0,5.05,5.06h11.48A5.07,5.07,0,0,0,257.63,326.52Z"></path>
                    <g id="el67ibpcbmvb">
                        <rect class="animable"
                              id="elrow1ejpk5w7"
                              style="fill: rgb(245, 245, 245); transform-origin: 287.91px 299.205px; transform: rotate(90deg);"
                              x="204.71"
                              y="285.52"
                              width="166.4"
                              height="27.37"></rect>
                    </g>
                    <g id="els6au41ftvh">
                        <rect class="animable"
                              id="elcdx66mkpo8c"
                              style="fill: rgb(240, 240, 240); transform-origin: 428.085px 315.67px; transform: rotate(180deg);"
                              x="420.49"
                              y="253.03"
                              width="15.19"
                              height="125.28"></rect>
                    </g>
                    <g id="el4m9ksf43e8w">
                        <rect class="animable"
                              id="elqp34h1z3hj"
                              style="fill: rgb(240, 240, 240); transform-origin: 360.64px 380.355px; transform: rotate(180deg);"
                              x="287.71"
                              y="378.31"
                              width="145.86"
                              height="4.09"></rect>
                    </g>
                    <rect class="animable"
                          id="elw4g8nckc579"
                          style="fill: rgb(250, 250, 250); transform-origin: 353.05px 315.67px;"
                          x="285.61"
                          y="253.03"
                          width="134.88"
                          height="125.28"></rect>
                    <path class="animable"
                          id="elzhgzuzent4f"
                          style="fill: rgb(240, 240, 240); transform-origin: 353.03px 311.63px;"
                          d="M312,326.24h82.06a14.61,14.61,0,1,0,0-29.22H312a14.61,14.61,0,1,0,0,29.22ZM394.08,298a13.63,13.63,0,1,1,0,27.26H312A13.63,13.63,0,0,1,312,298Z">
                    </path>
                    <path class="animable"
                          id="elico5fx57m5"
                          style="fill: rgb(240, 240, 240); transform-origin: 353.03px 347.98px;"
                          d="M312,362.59h82.06a14.61,14.61,0,0,0,0-29.22H312a14.61,14.61,0,0,0,0,29.22Zm82.06-28.24a13.63,13.63,0,1,1,0,27.25H312a13.63,13.63,0,1,1,0-27.25Z">
                    </path>
                    <path class="animable"
                          id="eln9ivlrv3wx"
                          style="fill: rgb(235, 235, 235); transform-origin: 353.05px 305.43px;"
                          d="M340.67,308.48h24.76a3.06,3.06,0,0,0,3.05-3.05h0a3.06,3.06,0,0,0-3.05-3.05H340.67a3.06,3.06,0,0,0-3.05,3.05h0A3.06,3.06,0,0,0,340.67,308.48Z">
                    </path>
                    <path class="animable"
                          id="elrx12nn4udz"
                          style="fill: rgb(240, 240, 240); transform-origin: 353.03px 275.28px;"
                          d="M312,289.89h82.06a14.61,14.61,0,1,0,0-29.22H312a14.61,14.61,0,1,0,0,29.22Zm82.06-28.24a13.63,13.63,0,0,1,0,27.26H312a13.63,13.63,0,1,1,0-27.26Z">
                    </path>
                    <path class="animable"
                          id="el9xiofafp9yj"
                          style="fill: rgb(235, 235, 235); transform-origin: 353.05px 269.105px;"
                          d="M340.67,272.13h24.76a3.06,3.06,0,0,0,3.05-3.05h0a3.05,3.05,0,0,0-3.05-3H340.67a3.05,3.05,0,0,0-3.05,3h0A3.06,3.06,0,0,0,340.67,272.13Z">
                    </path>
                    <path class="animable"
                          id="elwjswc67vjnj"
                          style="fill: rgb(235, 235, 235); transform-origin: 353.05px 341.82px;"
                          d="M340.67,344.82h24.76a3.05,3.05,0,0,0,3.05-3h0a3.06,3.06,0,0,0-3.05-3H340.67a3.06,3.06,0,0,0-3.05,3h0A3.05,3.05,0,0,0,340.67,344.82Z">
                    </path>
                    <g id="elcb63dvqyqqg">
                        <rect class="animable"
                              id="el1n8qzep3c03"
                              style="fill: rgb(240, 240, 240); transform-origin: 351.665px 249.855px; transform: rotate(180deg);"
                              x="282.84"
                              y="246.67"
                              width="137.65"
                              height="6.37"></rect>
                    </g>
                    <rect class="animable"
                          id="elgekrm6suwhg"
                          style="fill: rgb(230, 230, 230); transform-origin: 429.575px 249.855px;"
                          x="420.49"
                          y="246.67"
                          width="18.17"
                          height="6.37"></rect>
                    <path class="animable"
                          id="elu30590rp7al"
                          style="fill: rgb(224, 224, 224); transform-origin: 347.265px 183.306px;"
                          d="M322,146.39c3.07,1.54,11.39-.12,8.62,5.51a46.81,46.81,0,0,1-5.69,8.26c-3.1,3.83-2.51,8,1.15,9.48a4.41,4.41,0,0,1,2,1.4c1.69,2.42-2.29,5.66-4.25,8.08s-2.74,4.8-1.3,6.6c1.6,2,4.92,1.25,7.56,1.85,6.34,1.45-.18,10.2.49,14.69.46,3.08,3,3.94,6.35,4.37,2.77.36,6.46.61,6.61,3.44.14,2.46-3.06,5.24-3.9,7.82a8.09,8.09,0,0,0,.62,6.8,7.43,7.43,0,0,0,5,3.26c3.14.66,7.89,0,8.12,3.52.1,1.58-1,3-.24,4.44a5.1,5.1,0,0,0,3.69,2.17,26.91,26.91,0,0,0,9.06-.16c3.69-.68,9.14-3.93,7.14-7.06a4.28,4.28,0,0,0-2.86-1.64c-.88-.18-3.46.1-3.79-.5s.56-2.91.59-3.74a17.57,17.57,0,0,0-1.07-6.77,20.65,20.65,0,0,0-4.76-7.54c-.88-.89-2.27-1.54-2.45-2.83s.63-2.71,1.53-4c1.41-2,3.6-3.88,4.39-6,1.24-3.34-1.77-4.4-4.56-5.16-2.52-.69-5.84-1.57-5-4.63.62-2.21,3.41-4,4.24-6.18,1.13-2.89-1.61-3-3.56-4-2.55-1.34-3.19-3.74-2.27-6.77,1.53-5,10.7-12.07,6-15.32-1.19-.83-2.3-1.1-3-2.35s-.88-3-1.88-4.18c-1.58-1.91-4.85-2.23-6.55-4-3.51-3.64,4.06-10.09-2.85-11.63a8.2,8.2,0,0,1-4-1.67c-.63-.59-1.15-3.44-1.86-3.64-3.17-.88-8.88,5.27-10.68,7.16C326.45,137.75,318.36,144.55,322,146.39Z">
                    </path>
                    <path class="animable"
                          id="el7xnvhc77io8"
                          style="fill: rgb(245, 245, 245); transform-origin: 374.928px 174.774px;"
                          d="M376.39,231.21c-1.88-3.49-10.11-7-4.65-11a45.91,45.91,0,0,1,9.44-4.93c4.78-2,6.48-6.6,4.06-10.41a5.76,5.76,0,0,1-1-2.7c-.2-3.52,5.05-4.36,8.07-5.63s5-3.21,4.67-5.95c-.34-3-3.66-4.34-5.67-6.59-4.82-5.42,5.62-10.33,7.43-15.35,1.24-3.44-.5-5.87-3.26-8.42-2.25-2.09-5.38-4.63-4-7.63,1.2-2.6,5.51-3.46,7.63-5.58a10.33,10.33,0,0,0,3.1-7.35,9.59,9.59,0,0,0-2.65-6.43c-2.42-2.63-7-4.88-5.29-8.65.76-1.68,2.49-2.43,2.59-4.4a6.41,6.41,0,0,0-2.09-4.51,27.22,27.22,0,0,0-8.08-5.47c-3.62-1.6-10.17-1.65-10.08,2.8a5.45,5.45,0,0,0,1.64,3.45c.69.74,3.11,2.05,3.08,2.87s-2,2.63-2.53,3.46a23.24,23.24,0,0,0-2.67,7.6,28.42,28.42,0,0,0,.17,10.68c.29,1.45,1.18,3,.64,4.42s-2,2.38-3.47,3.11c-2.31,1.16-5.26,1.75-7.09,3.43-2.89,2.65-.8,5.61,1.26,8.12,1.86,2.27,4.31,5.23,1.92,7.84-1.73,1.88-5.16,2-7,3.69-2.54,2.27-.19,4.08,1,6.36,1.52,3,.81,5.8-1.63,8.33-4,4.18-15.9,5.72-13.49,12,.61,1.59,1.43,2.56,1.4,4.28s-.82,3.6-.58,5.45c.37,2.94,3.08,5.3,3.64,8.17,1.14,5.91-9,7.82-3.72,13.68a9.88,9.88,0,0,1,2.66,4.22c.25,1-.83,4.23-.31,4.88,2.33,2.87,10.66.13,13.26-.7C367.86,237.3,378.64,235.36,376.39,231.21Z">
                    </path>
                    <path class="animable"
                          id="el1t39pyng93j"
                          style="fill: rgb(240, 240, 240); transform-origin: 358.29px 235.005px;"
                          d="M397.47,223.34s-1,23.33-39.18,23.33-39.18-23.33-39.18-23.33Z"></path>
                </g>
                <g class="animable"
                   id="freepik--Shadow--inject-135"
                   style="transform-origin: 250px 416.24px;">
                    <ellipse class="animable"
                             id="freepik--path--inject-135"
                             style="fill: rgb(245, 245, 245); transform-origin: 250px 416.24px;"
                             cx="250"
                             cy="416.24"
                             rx="193.89"
                             ry="11.32"></ellipse>
                </g>
                <g class="animable"
                   id="freepik--Hourglass--inject-135"
                   style="transform-origin: 297.04px 308.295px;">
                    <g id="eldl2ir4acw47">
                        <g class="animable"
                           id="elsfxzfats8ra"
                           style="opacity: 0.2; transform-origin: 297.04px 308.295px;">
                            <polygon class="animable"
                                     id="ellbe2ba9xvh"
                                     style="fill: currentColor; transform-origin: 297.04px 349.01px;"
                                     points="360.73 407.87 297.04 290.15 233.35 407.87 360.73 407.87"></polygon>
                            <polygon class="animable"
                                     id="el5kxb9eqw8re"
                                     style="fill: currentColor; transform-origin: 297.04px 267.575px;"
                                     points="360.73 208.72 297.04 326.43 233.35 208.72 360.73 208.72"></polygon>
                        </g>
                    </g>
                    <path class="animable"
                          id="el4snshwu6abd"
                          style="fill: currentColor; transform-origin: 297.04px 280.001px;"
                          d="M308.71,278.22l-9.32,17.22a2.67,2.67,0,0,1-4.7,0l-9.32-17.22a10.21,10.21,0,0,1,9-15.06h5.39A10.21,10.21,0,0,1,308.71,278.22Z">
                    </path>
                    <path class="animable"
                          id="elnakv3md1do"
                          style="fill: currentColor; transform-origin: 297.065px 386.562px;"
                          d="M298.05,378.15,327,390.05a2.67,2.67,0,0,1-1,5.13H268.13a2.67,2.67,0,0,1-1-5.13L296,378.15A2.65,2.65,0,0,1,298.05,378.15Z">
                    </path>
                    <circle class="animable"
                            id="elea9qwfiqs1"
                            style="fill: currentColor; transform-origin: 297.04px 351.8px;"
                            cx="297.04"
                            cy="351.8"
                            r="3.71"></circle>
                    <circle class="animable"
                            id="elxrk01shszo"
                            style="fill: currentColor; transform-origin: 297.04px 313.05px;"
                            cx="297.04"
                            cy="313.05"
                            r="1.91"></circle>
                    <circle class="animable"
                            id="elh1qxin85txk"
                            style="fill: currentColor; transform-origin: 297.04px 331.52px;"
                            cx="297.04"
                            cy="331.52"
                            r="2.17"></circle>
                    <path class="animable"
                          id="eljfr18xsaywa"
                          style="fill: currentColor; transform-origin: 297.04px 407.865px;"
                          d="M360.41,402.06H233.67a5.82,5.82,0,0,0-5.8,5.81h0a5.82,5.82,0,0,0,5.8,5.8H360.41a5.82,5.82,0,0,0,5.8-5.8h0A5.82,5.82,0,0,0,360.41,402.06Z">
                    </path>
                    <path class="animable"
                          id="ellx7h37jw0q"
                          style="fill: currentColor; transform-origin: 297.04px 208.72px;"
                          d="M360.41,202.92H233.67a5.82,5.82,0,0,0-5.8,5.8h0a5.82,5.82,0,0,0,5.8,5.8H360.41a5.82,5.82,0,0,0,5.8-5.8h0A5.82,5.82,0,0,0,360.41,202.92Z">
                    </path>
                </g>
                <g class="animable"
                   id="freepik--Character--inject-135"
                   style="transform-origin: 221.525px 262.226px;">
                    <polygon class="animable"
                             id="el3ur612urk7d"
                             style="fill: rgb(255, 139, 123); transform-origin: 193.295px 396.22px;"
                             points="194.63 405.68 187.58 403.39 191.96 386.76 199.01 389.05 194.63 405.68"></polygon>
                    <path class="animable"
                          id="ellodab3r5lx"
                          style="fill: rgb(38, 50, 56); transform-origin: 183.337px 407.669px;"
                          d="M187.47,402.45l7.92,2.57a.54.54,0,0,1,.37.65l-1.65,6.4a1.31,1.31,0,0,1-1.64.85c-2.74-.94-4-1.53-7.49-2.66-2.15-.7-9.21-2.52-12.17-3.48s-1.93-3.86-.59-3.72c6,.63,11.4.35,13.9-.57A2.09,2.09,0,0,1,187.47,402.45Z">
                    </path>
                    <g id="elk5k2kui2t5b">
                        <polygon class="animable"
                                 id="ellspwpuno9mf"
                                 style="opacity: 0.2; transform-origin: 194.355px 392.195px;"
                                 points="199.01 389.06 191.96 386.76 189.7 395.34 196.76 397.63 199.01 389.06">
                        </polygon>
                    </g>
                    <path class="animable"
                          id="ellmxcadpozx"
                          style="fill: currentColor; transform-origin: 215.965px 308.44px;"
                          d="M218.28,220.72s-12.65,58.55-15.62,79.6c-3.25,23.05-15.46,92.27-15.46,92.27l13.09,3.62s18.14-67.13,23.44-89.54c5.75-24.33,21-86,21-86Z">
                    </path>
                    <g id="elj589zo8777">
                        <path class="animable"
                              id="elwlzhzp06fon"
                              style="opacity: 0.3; transform-origin: 233.604px 262.129px;"
                              d="M233.92,239.92c-5,11.34-7.47,36-5.53,47.35,3.54-14.55,7.8-31.85,11.09-45.16C238.37,238.25,236.53,234,233.92,239.92Z">
                        </path>
                    </g>
                    <polygon class="animable"
                             id="elrbs1kznj6j"
                             style="fill: rgb(38, 50, 56); transform-origin: 194.63px 391.685px;"
                             points="200.62 396.47 186.6 392.61 186.88 386.9 202.66 392.35 200.62 396.47"></polygon>
                    <path class="animable"
                          id="elmbc88b04h6c"
                          style="fill: rgb(38, 50, 56); transform-origin: 185.036px 401.999px;"
                          d="M184.57,402.87a9.63,9.63,0,0,0,2,.36.18.18,0,0,0,.16-.28c-.18-.23-1.73-2.24-2.7-2.18a.65.65,0,0,0-.54.34,1,1,0,0,0-.08,1A2,2,0,0,0,184.57,402.87Zm1.59,0c-1.34-.16-2.26-.5-2.48-.93a.62.62,0,0,1,.07-.63.32.32,0,0,1,.26-.17C184.53,401.08,185.51,402.06,186.16,402.84Z">
                    </path>
                    <path class="animable"
                          id="el44vzhhk3mx9"
                          style="fill: rgb(38, 50, 56); transform-origin: 186.386px 401.426px;"
                          d="M186.5,403.22h.08a.18.18,0,0,0,.13-.11c0-.08.85-2.06.36-3a.85.85,0,0,0-.62-.45.66.66,0,0,0-.76.3c-.41.72.16,2.53.73,3.18Zm0-3.17a.5.5,0,0,1,.31.26,3.85,3.85,0,0,1-.27,2.39,3.52,3.52,0,0,1-.51-2.53c0-.09.14-.19.39-.14Z">
                    </path>
                    <path class="animable"
                          id="elz7s9nhx3p2"
                          style="fill: rgb(38, 50, 56); transform-origin: 204.115px 176.535px;"
                          d="M231.74,165.13c-.38.9-.7,1.58-1.05,2.34s-.73,1.46-1.1,2.18c-.74,1.45-1.52,2.86-2.33,4.27a82.48,82.48,0,0,1-5.4,8.18,62,62,0,0,1-6.65,7.59,38.5,38.5,0,0,1-8.68,6.42l-.25.13a5.17,5.17,0,0,1-1.28.46,14.21,14.21,0,0,1-6.87-.27,20,20,0,0,1-5.24-2.44,34,34,0,0,1-7.24-6.56,60.17,60.17,0,0,1-5.27-7.31,65.7,65.7,0,0,1-4.13-7.85,3.24,3.24,0,0,1,5.47-3.35l.1.12c1.65,2,3.44,4.13,5.24,6.07a68.41,68.41,0,0,0,5.58,5.48,27.46,27.46,0,0,0,5.74,4,8.46,8.46,0,0,0,2.47.82,2.74,2.74,0,0,0,1.44-.12l-1.53.59a29.94,29.94,0,0,0,5.61-4.9,61.91,61.91,0,0,0,5-6.42c1.58-2.3,3.08-4.71,4.49-7.19.72-1.23,1.41-2.48,2.06-3.75l1-1.89c.31-.61.65-1.31.89-1.8l.06-.14a6.5,6.5,0,0,1,11.85,5.34Z">
                    </path>
                    <g id="el8l7cxyhlbpm">
                        <path class="animable"
                              id="elojpn40s0vkp"
                              style="opacity: 0.3; transform-origin: 220.898px 181.11px;"
                              d="M215.39,178.71c3.14-8.34,9.81-8.48,12.7-6.27-.21.39-.43.78-.65,1.17a84.91,84.91,0,0,1-5.15,7.91A65.35,65.35,0,0,1,216,188.9c-.72.71-1.46,1.41-2.23,2.09A32,32,0,0,1,215.39,178.71Z">
                        </path>
                    </g>
                    <path class="animable"
                          id="eleymngqgl5bu"
                          style="fill: rgb(255, 139, 123); transform-origin: 174.559px 169.555px;"
                          d="M176,172.79l-6.5.24,1.62-6.95a33.54,33.54,0,0,1,6.63,1,2.63,2.63,0,0,1,1.41,4h0A3.91,3.91,0,0,1,176,172.79Z">
                    </path>
                    <path class="animable"
                          id="elgkr0baohdz"
                          style="fill: currentColor; transform-origin: 177px 169.625px;"
                          d="M179.64,166.92a6.28,6.28,0,0,0-2.15-1.11c-.54,2.84-4,7.63-4,7.63h2.71a2.38,2.38,0,0,0,1.83-.85l1.9-2.28A2.37,2.37,0,0,0,179.64,166.92Z">
                    </path>
                    <polygon class="animable"
                             id="elpuq577umn8"
                             style="fill: rgb(255, 139, 123); transform-origin: 167.81px 168.98px;"
                             points="164.52 169.83 166.34 164.93 171.1 166.09 169.48 173.03 164.52 169.83"></polygon>
                    <polygon class="animable"
                             id="elwrnkyvxsst"
                             style="fill: rgb(255, 139, 123); transform-origin: 242.415px 400.335px;"
                             points="246.25 408.92 238.84 408.92 238.58 391.75 245.99 391.75 246.25 408.92"></polygon>
                    <path class="animable"
                          id="el7mzpufterwv"
                          style="fill: rgb(38, 50, 56); transform-origin: 235.354px 412.275px;"
                          d="M238.45,408.06h8.33a.53.53,0,0,1,.55.51l.4,6.59a1.32,1.32,0,0,1-1.3,1.32c-2.9-.05-4.28-.22-8-.22-2.25,0-9.78.23-12.89.23s-3-3.08-1.71-3.36c5.92-1.24,11.2-3,13.29-4.61A2.07,2.07,0,0,1,238.45,408.06Z">
                    </path>
                    <g id="elbtqbt8vybr">
                        <polygon class="animable"
                                 id="elvuecnnnqfn"
                                 style="opacity: 0.2; transform-origin: 242.355px 396.185px;"
                                 points="246 391.76 238.58 391.76 238.72 400.61 246.13 400.61 246 391.76"></polygon>
                    </g>
                    <path class="animable"
                          id="elyx8wvhtt7ha"
                          style="fill: currentColor; transform-origin: 244.372px 309.595px;"
                          d="M232.74,220.72s-2.83,64.41-1.63,85.64c1.32,23.24,4.08,92.11,4.08,92.11h13.58s3.42-67,4.24-90c.89-25,4.92-87.75,4.92-87.75Z">
                    </path>
                    <polygon class="animable"
                             id="el61szoejbhl2"
                             style="fill: rgb(38, 50, 56); transform-origin: 241.625px 395.74px;"
                             points="249.32 398.47 234.65 398.47 233.53 393.01 249.72 393.82 249.32 398.47"></polygon>
                    <path class="animable"
                          id="elwbdl6n3mdfs"
                          style="fill: rgb(38, 50, 56); transform-origin: 236.072px 408.42px;"
                          d="M235.82,409.35a9.69,9.69,0,0,0,2-.26.2.2,0,0,0,.13-.14.19.19,0,0,0-.07-.17c-.24-.17-2.34-1.6-3.25-1.24a.66.66,0,0,0-.4.48,1,1,0,0,0,.22.94A2,2,0,0,0,235.82,409.35Zm1.5-.51c-1.33.26-2.3.22-2.65-.12a.64.64,0,0,1-.12-.62.3.3,0,0,1,.19-.24C235.23,407.67,236.46,408.29,237.32,408.84Z">
                    </path>
                    <path class="animable"
                          id="eljw5mh8k68w"
                          style="fill: rgb(38, 50, 56); transform-origin: 236.964px 407.429px;"
                          d="M237.76,409.09a.13.13,0,0,0,.08,0,.18.18,0,0,0,.09-.14c0-.09.17-2.22-.58-2.94a.87.87,0,0,0-.73-.24.66.66,0,0,0-.62.52c-.18.81.93,2.36,1.67,2.8A.15.15,0,0,0,237.76,409.09Zm-1-3a.5.5,0,0,1,.37.15,3.83,3.83,0,0,1,.49,2.36c-.64-.55-1.38-1.73-1.27-2.26,0-.1.08-.22.33-.25Z">
                    </path>
                    <path class="animable"
                          id="elczv2xhuotku"
                          style="fill: rgb(38, 50, 56); transform-origin: 239.064px 187.53px;"
                          d="M261.64,160.94a4.72,4.72,0,0,0-4-5.5h-.08c-2.39-.35-5.39-.71-8.33-.85a147.89,147.89,0,0,0-16.85,0c-2.59.24-5.12.67-7.14,1.06l-.08,0a7.08,7.08,0,0,0-5.39,4.94c-2.42,8.15-5.31,24.79-1.53,60.12h39.65c.28-3.54-.51-15.06.07-29.73A234.86,234.86,0,0,1,261.64,160.94Z">
                    </path>
                    <g id="elu13b2dv51co">
                        <path class="animable"
                              id="eljwod4ys6ib"
                              style="opacity: 0.3; transform-origin: 257.826px 171.692px;"
                              d="M261.26,163.12c-.82,4.74-1.83,11.19-2.53,18,0,0-3.62-7.1-4.28-13.17S259,161.42,261.26,163.12Z">
                        </path>
                    </g>
                    <g id="eliy0zcmfnme">
                        <g class="animable"
                           id="eldecpi97eua"
                           style="opacity: 0.2; transform-origin: 241.528px 159.49px;">
                            <path class="animable"
                                  id="eldktxs275ba6"
                                  style="fill: rgb(255, 255, 255); transform-origin: 240.855px 160.481px;"
                                  d="M234.67,164.06a.38.38,0,0,1-.17-.71l12.36-6.41a.38.38,0,0,1,.5.16.38.38,0,0,1-.16.51L234.84,164A.47.47,0,0,1,234.67,164.06Z">
                            </path>
                            <path class="animable"
                                  id="elnh0af841r3r"
                                  style="fill: rgb(255, 255, 255); transform-origin: 236.942px 160.901px;"
                                  d="M240.33,164.64a.33.33,0,0,1-.26-.11l-6.78-6.73a.39.39,0,0,1,0-.53.38.38,0,0,1,.53,0l6.77,6.74a.38.38,0,0,1,0,.53A.36.36,0,0,1,240.33,164.64Z">
                            </path>
                            <path class="animable"
                                  id="el3c5jzw19s39"
                                  style="fill: rgb(255, 255, 255); transform-origin: 241.528px 157.245px;"
                                  d="M249.26,154.58a147.71,147.71,0,0,0-16.84,0l-.28,0a4,4,0,0,0,.43,3.07c.94,1.5,2.91,2.34,5.87,2.5l1.11,0c8,0,11.09-4.86,11.22-5.07l.28-.45Z">
                            </path>
                        </g>
                    </g>
                    <path class="animable"
                          id="elhline2skao"
                          style="fill: rgb(255, 139, 123); transform-origin: 241.461px 147.444px;"
                          d="M233.22,154.52c4.9-1.16,5.76-4.19,5.43-7.52a19.92,19.92,0,0,0-.39-2.48l6.14-5.1,4.51-3.74c-1.25,5.43-2.66,15.32,1,18.94,0,0-3,5-11.43,4.56C231.41,158.79,233.22,154.52,233.22,154.52Z">
                    </path>
                    <g id="el5j8mp0vx9cd">
                        <path class="animable"
                              id="el1betoadfua2"
                              style="opacity: 0.2; transform-origin: 241.345px 143.21px;"
                              d="M238.26,144.52a19.92,19.92,0,0,1,.39,2.48c2.29-.46,5.35-2.9,5.67-5.24a10.66,10.66,0,0,0,.08-2.34Z">
                        </path>
                    </g>
                    <path class="animable"
                          id="el9v4rj1urit4"
                          style="fill: rgb(38, 50, 56); transform-origin: 235.03px 123.794px;"
                          d="M235,118.5c-3.33,2-2.8,7-3.7,10.58,2.12.21,5.46-3.56,5.46-3.56l2-5.73Z"></path>
                    <path class="animable"
                          id="elumbu1s8nxul"
                          style="fill: rgb(255, 139, 123); transform-origin: 241.723px 130.152px;"
                          d="M252.71,128.56c-2.13,7.06-3,11.29-7.52,14.24a9.59,9.59,0,0,1-14.92-8.11c0-6.73,3.46-17.15,11.18-18.59A9.7,9.7,0,0,1,252.71,128.56Z">
                    </path>
                    <path class="animable"
                          id="el597ab3qm26r"
                          style="fill: rgb(38, 50, 56); transform-origin: 246.584px 121.265px;"
                          d="M246.06,134.55c5-5.8-1.25-8.66,3.86-12.69-5.75.27-15.22-.14-16.91-4.08s3.51-9.28,7.84-9.78c5-.58,3.92,5.61,3.92,5.61s19.13-1.19,13.06,7c4.6-.28,3.33,7.16-4.67,13.44C251.15,134.72,246.06,134.55,246.06,134.55Z">
                    </path>
                    <path class="animable"
                          id="el89ix20xt6rf"
                          style="fill: rgb(38, 50, 56); transform-origin: 259.006px 118.565px;"
                          d="M256.68,120.71s3.94-1.17,3.81-4.29C261.91,117.4,262.06,120.38,256.68,120.71Z"></path>
                    <path class="animable"
                          id="el0ptsdfyahp4n"
                          style="fill: rgb(255, 139, 123); transform-origin: 250.961px 134.941px;"
                          d="M253.88,135.93a7.91,7.91,0,0,1-4.55,2.77c-2.27.41-2.8-1.69-1.67-3.74,1-1.84,3.43-4.27,5.47-3.76S255.33,134.14,253.88,135.93Z">
                    </path>
                    <path class="animable"
                          id="el8csja3z0uf"
                          style="fill: rgb(38, 50, 56); transform-origin: 240.624px 128.236px;"
                          d="M241.32,128.38c-.14.58-.56,1-.95.91s-.58-.61-.44-1.19.56-1,.94-.92S241.46,127.79,241.32,128.38Z">
                    </path>
                    <path class="animable"
                          id="el0hh7zv8rjcmv"
                          style="fill: rgb(38, 50, 56); transform-origin: 233.995px 126.915px;"
                          d="M234.69,127.05c-.14.58-.56,1-.94.92s-.59-.61-.45-1.19.56-1,.94-.92S234.83,126.47,234.69,127.05Z">
                    </path>
                    <path class="animable"
                          id="elz62h77o9jkb"
                          style="fill: rgb(255, 86, 82); transform-origin: 234.73px 130.517px;"
                          d="M236.73,127.76a22.22,22.22,0,0,1-4,4.42,3.42,3.42,0,0,0,2.68,1.09Z"></path>
                    <path class="animable"
                          id="elborqzhnc2ow"
                          style="fill: rgb(38, 50, 56); transform-origin: 238.99px 134.556px;"
                          d="M237.45,135.31a5.13,5.13,0,0,0,3.85-1.24.16.16,0,0,0,0-.24.18.18,0,0,0-.25,0,4.89,4.89,0,0,1-4.22,1.05.17.17,0,0,0-.2.14.18.18,0,0,0,.14.21Z">
                    </path>
                    <path class="animable"
                          id="elmwru7c6a7q"
                          style="fill: rgb(38, 50, 56); transform-origin: 242.801px 125.535px;"
                          d="M243.88,126.76a.27.27,0,0,0,.17,0,.34.34,0,0,0,.17-.46,3.36,3.36,0,0,0-2.47-2,.36.36,0,0,0-.4.3.35.35,0,0,0,.31.39,2.69,2.69,0,0,1,1.92,1.58A.36.36,0,0,0,243.88,126.76Z">
                    </path>
                    <path class="animable"
                          id="elxxoxzeuwzz"
                          style="fill: rgb(38, 50, 56); transform-origin: 234.579px 122.366px;"
                          d="M233.05,123.07a.32.32,0,0,0,.32-.06,2.89,2.89,0,0,1,2.52-.59.35.35,0,1,0,.22-.67h0a3.64,3.64,0,0,0-3.17.71.35.35,0,0,0-.06.49A.3.3,0,0,0,233.05,123.07Z">
                    </path>
                    <path class="animable"
                          id="elna5yyo96xh"
                          style="fill: rgb(38, 50, 56); transform-origin: 264.362px 183.029px;"
                          d="M262,158.09l.83,1.13.75,1.06c.5.71.95,1.42,1.42,2.13.91,1.43,1.77,2.88,2.6,4.34a95.76,95.76,0,0,1,4.52,9c.7,1.52,1.3,3.1,1.94,4.65s1.18,3.16,1.67,4.78a88.81,88.81,0,0,1,2.6,9.83l.08.38a5.22,5.22,0,0,1-.71,3.94,28.6,28.6,0,0,1-4.55,5.39,23.54,23.54,0,0,1-6,4,21.55,21.55,0,0,1-6.86,1.9,20.48,20.48,0,0,1-3.5.06c-.58,0-1.16-.11-1.74-.2l-.88-.17-1-.25a.46.46,0,0,1-.34-.55l1.38-5.8c0-.05.26-.06.42-.1l.55-.11c.38-.08.75-.17,1.13-.27a15.91,15.91,0,0,0,2.17-.76,15.5,15.5,0,0,0,3.79-2.23,19.16,19.16,0,0,0,5.26-6.85l-.63,4.32c-.86-2.83-1.77-5.63-2.87-8.4s-2.3-5.49-3.61-8.17-2.71-5.33-4.22-7.91c-.74-1.29-1.52-2.56-2.3-3.82l-1.19-1.86-.59-.9-.55-.8-.2-.3A6.49,6.49,0,0,1,262,158.09Z">
                    </path>
                    <path class="animable"
                          id="elg8ynoqrz4hr"
                          style="fill: rgb(255, 139, 123); transform-origin: 251.728px 209.18px;"
                          d="M248.78,209.48,246.63,213l9.33-.37s2.45-6.28-.89-7.27l-1.3.35A8.56,8.56,0,0,0,248.78,209.48Z">
                    </path>
                    <path class="animable"
                          id="el2djy0fsxddi"
                          style="fill: currentColor; transform-origin: 254.424px 208.234px;"
                          d="M252.62,204.55a6.26,6.26,0,0,0-1.7,1.71c2.54,1.38,6.08,6.08,6.08,6.08l.82-2.58a2.38,2.38,0,0,0-.27-2L256,205.26A2.38,2.38,0,0,0,252.62,204.55Z">
                    </path>
                    <polygon class="animable"
                             id="el4xmh8mle4qo"
                             style="fill: rgb(255, 139, 123); transform-origin: 251.295px 215.525px;"
                             points="247.45 218.42 255.14 217.74 255.96 212.63 246.63 213 247.45 218.42"></polygon>
                </g>
                <g class="animable"
                   id="freepik--Clock--inject-135"
                   style="transform-origin: 169.22px 124.685px;">
                    <path class="animable"
                          id="elh1jl6qxurgg"
                          style="fill: currentColor; transform-origin: 155.025px 94.77px;"
                          d="M153.06,96.34l-.51-.86a35.39,35.39,0,0,1,4.57-2.28l.38.93A33.38,33.38,0,0,0,153.06,96.34Z">
                    </path>
                    <path class="animable"
                          id="eliofi32b960i"
                          style="fill: currentColor; transform-origin: 143.91px 105.65px;"
                          d="M138.46,114l-1-.34A34.81,34.81,0,0,1,149.77,97.3l.59.81A33.7,33.7,0,0,0,138.46,114Z">
                    </path>
                    <circle class="animable"
                            id="elw02m1h3dddl"
                            style="fill: currentColor; transform-origin: 170.2px 125.39px;"
                            cx="170.2"
                            cy="125.39"
                            r="30.78"></circle>
                    <g id="elt6fjz79wjq">
                        <path class="animable"
                              id="el0n32epsxcb0h"
                              style="fill: rgb(255, 255, 255); opacity: 0.6; transform-origin: 170.2px 125.382px;"
                              d="M195.91,125.39a25.71,25.71,0,1,1-6.72-17.34.06.06,0,0,1,.05,0A25.66,25.66,0,0,1,195.91,125.39Z">
                        </path>
                    </g>
                    <path class="animable"
                          id="el7s44vg38fii"
                          style="fill: rgb(255, 255, 255); transform-origin: 170.951px 126.143px;"
                          d="M195.91,125.39a25.71,25.71,0,0,1-43.15,18.89,25.71,25.71,0,0,1,36.43-36.23.06.06,0,0,1,.05,0A25.66,25.66,0,0,1,195.91,125.39Z">
                    </path>
                    <path class="animable"
                          id="elqkfgakdsym"
                          style="fill: rgb(38, 50, 56); transform-origin: 167.738px 119.101px;"
                          d="M170.2,126.89a1.49,1.49,0,0,1-1.06-.44L156.6,113.91a1.5,1.5,0,1,1,2.12-2.12l11.48,11.48,6.63-6.63a1.5,1.5,0,0,1,2.12,2.12l-7.69,7.69A1.51,1.51,0,0,1,170.2,126.89Z">
                    </path>
                </g>
                <defs>
                    <filter id="active"
                            height="200%">
                        <feMorphology in="SourceAlpha"
                                      result="DILATED"
                                      operator="dilate"
                                      radius="2"></feMorphology>
                        <feFlood flood-color="#32DFEC"
                                 flood-opacity="1"
                                 result="PINK"></feFlood>
                        <feComposite in="PINK"
                                     in2="DILATED"
                                     operator="in"
                                     result="OUTLINE"></feComposite>
                        <feMerge>
                            <feMergeNode in="OUTLINE"></feMergeNode>
                            <feMergeNode in="SourceGraphic"></feMergeNode>
                        </feMerge>
                    </filter>
                    <filter id="hover"
                            height="200%">
                        <feMorphology in="SourceAlpha"
                                      result="DILATED"
                                      operator="dilate"
                                      radius="2"></feMorphology>
                        <feFlood flood-color="#ff0000"
                                 flood-opacity="0.5"
                                 result="PINK"></feFlood>
                        <feComposite in="PINK"
                                     in2="DILATED"
                                     operator="in"
                                     result="OUTLINE"></feComposite>
                        <feMerge>
                            <feMergeNode in="OUTLINE"></feMergeNode>
                            <feMergeNode in="SourceGraphic"></feMergeNode>
                        </feMerge>
                        <feColorMatrix type="matrix"
                                       values="0   0   0   0   0                0   1   0   0   0                0   0   0   0   0                0   0   0   1   0 "
                                       values="0   0   0   0   0                0   1   0   0   0                0   0   0   0   0                0   0   0   1   0 "
                                       values="0   0   0   0   0                0   1   0   0   0                0   0   0   0   0                0   0   0   1   0 "
                                       values="0   0   0   0   0                0   1   0   0   0                0   0   0   0   0                0   0   0   1   0 ">
                        </feColorMatrix>
                    </filter>
                </defs>
            </svg>
            <div class="mx-auto text-center mt-0">
                <h1 class="mb-4 text-7xl font-extrabold tracking-tight text-blue-600 dark:text-blue-500">
                    419
                </h1>
                <p class="mb-4 text-3xl font-bold tracking-tight text-gray-900 dark:text-white md:text-4xl">Page Expired
                </p>
                <p class="mb-2.5 text-lg font-light text-gray-500 dark:text-gray-400">
                    Sorry, your session has expired. Please refresh and try again.
                </p>
                <a class="inline-flex rounded-lg bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900"
                   href="/">
                    Back to Home
                </a>
            </div>
        </div>
    </section>

    {{-- <section class="bg-white dark:bg-gray-900">
        <div class="mx-auto max-w-screen-xl px-4 py-8 lg:px-6 lg:py-16">
            <div class="mx-auto max-w-screen-sm text-center">
                <h1 class="mb-4 text-7xl font-extrabold tracking-tight text-blue-600 dark:text-blue-500">
                    419
                </h1>
                <p class="mb-4 text-3xl font-bold tracking-tight text-gray-900 dark:text-white md:text-4xl">Page Expired
                </p>
                <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">
                    Sorry, your session has expired. Please refresh and try again.
                </p>
            </div>
        </div>
    </section> --}}
@endsection
