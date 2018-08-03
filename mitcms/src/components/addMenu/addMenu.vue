<template>
    <div class="addMenuShade" v-show="show">
        <el-card class="addMenu">
            <div slot="header" class="clearfix">
                <span class="addHeader">添加到歌单~</span>
            </div>
            <div class="text item" @click="addNewList">
                创建新歌单
            </div>
            <scroll class="scroll" :data="list">
                <div>
                    <div v-for="item in list" class="text item" @click="select(item)">
                        {{item.name}}
                    </div>
                </div>
            </scroll>
            <!-- <div class="text item" v-for="item in list">
                {{item.name}}
            </div> -->
            <i class="close el-icon-close" @click="close"></i>
        </el-card>
    </div>
</template>

<script>
    import {createSongList} from 'api/songlist'
    import {getSongList} from 'api/songlist'
    import Scroll from 'base/scroll/scroll'

    export default {
      name: 'addMenu',
      props: {
        show: {
          type: Boolean,
          default: false,
          list: []
        }
      },
      data() {
        return {
            list: []
        }
      },
      created() {
        this._getSongList()
      },
      methods: {
        close() {
          this.$emit('close')
        },
        addNewList() {
          this.$prompt('请输入歌单名称','创建一个新的歌单').then((res) => {
            createSongList({
              'name': res.value,
              'type': 1
            }).then((res) => {
              if(res.data.errorCode === 0) {
                this.list.push(res.data.data)
                this.$alert('歌单创建好了', '提示')
              }
            })
          })
        },
        _getSongList() {
            getSongList().then((res) => {
                if(res.data.errorCode === 0) {
                    this.list = res.data.data;
                }
            })
        },
        select(item) {
            console.log(item)
            this.$emit('selectList', item)
        }

      },
      components: {
          Scroll
      }
    }
</script>

<style>
    .addMenuShade {
        position: fixed;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        background: rgba(0,0,0, 0.6);
        z-index: 9999;
    }
    .addMenu {
        position: relative;
        width: 300px;
        margin: 100px auto;
    }
    .addMenu .addHeader {
        font-size: 20px;
    }
    .addMenu  .item {
        font-size: 15px;
        color: #777;
        cursor: pointer;
        line-height: 40px;
    }

    .close {
        position: absolute;
        right: 10px;
        top: 20px;
        font-size: 30px;
        color: #000;
        cursor: pointer;
    }

    .scroll {
        height: 200px; 
        overflow:hidden; 
        position: relative;
    }

</style>