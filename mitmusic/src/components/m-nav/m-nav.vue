<template>
    <nav class="nav">
        <router-link tag="div" class="nav-item" to="/songList">
            <span class="nav-link">歌单广场</span>
        </router-link>
        <router-link tag="div" class="nav-item" to="/singer">
            <span class="nav-link">热门歌手</span>
        </router-link>
        <router-link tag="div" class="nav-item" to="/rank">
            <span class="nav-link">排行榜</span>
        </router-link>
        <router-link tag="div" class="nav-item" to="/forum">
            <span class="nav-link">歌荒互助</span>
        </router-link>
        <router-link tag="div" class="nav-item" to="/recommend">
            <span class="nav-link">站长推荐</span>
        </router-link>
    </nav>
</template>

<script>
    export default {
      name: 'm-nav'
    }
</script>

<style lang="stylus">
    @import "~common/stylus/variable.styl"
    .nav
        display: block
        font-size: 0
        .nav-item
            margin-right: 20px
            display: inline
            .nav-link
                font-size: 18px
                color: $navColor
                cursor: pointer
            &.router-link-active
                .nav-link
                    font-size: 19px
                    font-weight: bold
                    color: $activeColor
</style>