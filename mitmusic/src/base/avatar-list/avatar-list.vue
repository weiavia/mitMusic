<template>
    <scroll class="listWrapper">
        <ul class="singerList">
            <li class="item" v-for="item in list" @click="selectItem(item)">
                <img v-lazy="item.avatar" :alt="item.name" class="face">
                <p class="name">{{item.name}}</p>
            </li>
        </ul>
    </scroll>
</template>

<script>
  import Scroll from 'base/scroll/scroll'
  export default {
    props: {
      list: {
        type: Array,
        default: []
      }
    },
    methods: {
      selectItem(item) {
        this.$emit('selectItem', item)
      }
    },
    components: {
      Scroll
    }
  }
</script>

<style lang="stylus" scope>
    .listWrapper
        height: 100%
        overflow: hidden
        .singerList
            font-size: 0
            .item
                display: inline-block
                width: calc(25% - 10px)
                margin-right 10px
                margin-bottom 10px
                cursor: pointer
                .face
                    width: 100%
                .name
                    font-size: 15px
                    color: #777
                    text-align: center
                    line-height: 30px
                    text-overflow: ellipsis
                    white-space: nowrap
                    overflow: hidden

</style>