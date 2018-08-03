<template>
    <div>
        <div class="box">
            <i class="iconfont icon-sousuo"></i>
            <input type="text" @focus="onFocus">
        </div>
    </div>
</template>

<script>
    export default {
      name: 'search-box',

      methods: {
        onFocus() {
            this.$emit('searchFocus')
        }
      }
    }
</script>

<style lang="stylus">
    @import "~common/stylus/variable.styl"
    .box
        width: 300px
        height: 38px
        box-sizing: border-box
        border: 1px solid $borderColor
        input
            width: 100%
            height: 100%
            text-indent: 10px
        .iconfont
            position: absolute
            right: 4px
            top: 4px
            color: #666
            font-size: 30px
</style>