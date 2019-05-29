<template>
    <div>
        <nav class="navbar navbar-default navbar-expand-lg navbar-light">
            <div class="navbar-header d-flex col">
                <a class="navbar-brand" href="#">Brand<b>Name</b></a>
                <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
                    <span class="navbar-toggler-icon"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collection of nav links, forms, and other content for toggling -->
            <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item">
                        <router-link tag="a" :class="'nav-link'" :to="{ name: 'add_member'}">
                             Add Member
                        </router-link>
                       </li>

                    <li class="nav-item active">
                        <router-link tag="a" :class="'nav-link'" :to="{ name: 'all_member'}">
                            View Member
                        </router-link></li>
                    <li class="nav-item dropdown">
                        <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">Admin <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item">Logout</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>
        <router-view></router-view>
    </div>



</template>

<script>
    export default {
        data() {
            return{

            }
        },
    }
</script>
