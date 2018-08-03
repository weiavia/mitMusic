<template>
  <div class="listWrapper">
    <p class="back" @click="back">Back</p>
    <el-table
      :data="songs"
      style="width: 100%">
      <el-table-column
        prop="name"
        label="歌曲名称"
        width="180">
      </el-table-column>
      <el-table-column
        prop="singer"
        label="歌手"
        width="180">
      </el-table-column>
      <el-table-column
        prop="address"
        label="操作">
        <template slot-scope="scope">
          <el-button type="text" size="small">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import {getSongs} from 'api/songlist'
export default {
  data() {
    return {
      songs: []
    }
  },
  created() {
    this.id = this.$route.params.id
    this._getSongs()
  },
  methods: {
    _getSongs() {
      getSongs({listid: this.id}).then((res) => {        
        if(res.data.errorCode === 0) {
          this.songs = res.data.data
        }
      })
    },
    back() {
      this.$router.back()
    }
  }

}
</script>

<style scope>
.listWrapper {
  width: 100%;
  height: 100%;
  background: #eee;
  position: absolute;
  top: 0;
  left: 0;
  box-sizing: border-box;
  padding: 10px 20px;
}
.back {
  font-size: 20px;
  margin-bottom: 10px;
  cursor: pointer;
}
</style>
