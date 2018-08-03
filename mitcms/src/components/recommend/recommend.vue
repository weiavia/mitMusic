<template>
  <div>
    <div class="search-box">
      <el-input v-model="query" placeholder="搜索歌曲" class="txt"></el-input>
      <el-button type="info" class="button" @click="_search">搜索</el-button>
    </div>

     <el-table
      :data="songs"
      style="width: 100%; margin-top: 10px;"
      @row-click="select"
      >
        <el-table-column
            prop="name"
            label="歌曲名称"
            width="250">
        </el-table-column>
        <el-table-column
            prop="singer"
            label="歌手名称"
        >
        </el-table-column>

      </el-table>

      <addMenu :show="menuShow" @close="closeMenu" @selectList="selectList"></addMenu>
  </div>
</template>

<script>
import {search} from 'api/search'
import {ERR_OK} from 'api/config'
import {addToSongList} from 'api/songlist'
import {createSong} from '../../common/js/song'
import AddMenu from 'components/addMenu/addMenu'

export default {
    data() {
        return {
            songs: [],
            query: '',
            currentPage: 0,
            num: 20,
            menuShow: false,
            currentSong: null
        }
    },
    methods: {
        select(song) {
            this.currentSong = song
            this.menuShow = true
        },
        _search() {
            search(this.query, this.currentPage, false, this.num).then((res) => {
              if (res.code === ERR_OK)
                  this.normalizeSearch(res.data)
            })
        },
        normalizeSearch(data) {
          let resSongs = []
          let songs = data.song.list
          songs.forEach((e) => {
            resSongs.push(createSong(e))
          })
          this.songs = resSongs
        },
        closeMenu() {
          this.menuShow = false
        },
        selectList({id}) {
            this.toSonglist(id)
        },
        toSonglist(listId) {
            let params = this.getParams()
            params.listid = listId
            addToSongList(params).then((res) => {
                this.menuShow = false
                if(res.data.errorCode === ERR_OK) {
                    this.$confirm('提示', '添加成功！')
                }
            })
        },
        getParams() {
            return {
                'avatar': this.currentSong.image,
                'mid': this.currentSong.mid,
                'name': this.currentSong.name,
                'singer': this.currentSong.singer
            }
        }
        
    },
    components: {
      AddMenu
    }
}
</script>

<style>
.search-box {
    display: flex;
}
.search-box .txt {
    margin-right: 10px;
}
.el-table__row {
    cursor: pointer
}

</style>
