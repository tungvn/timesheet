<template>
    <div class="wrapper">
        <nav-bar/>
        <aside-menu/>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark" v-text="heading"></h1>
                        </div>
                        <div class="col-sm-6">
                            <slot name="header"></slot>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <slot name="content"></slot>
                    </div>
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <strong>Copyright © 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.0.0
            </div>
        </footer>

        <div id="sidebar-overlay"></div>
    </div>
</template>

<script>
    import NavBar from "./NavBar";
    import AsideMenu from "./AsideMenu";

    export default {
        props: {
            heading: {
                type: String,
                require: true,
            }
        },

        components: {
            NavBar,
            AsideMenu,
        }
    }
</script>
