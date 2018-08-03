<template>
  <div>
    <div class="list-wrapper">
      <div class="list-item" v-for="item in lists" @click="showDetail(item)">
        <img :src="item.avatar" alt="" v-if="item.avatar">
        <img src="./default.png" alt="" v-else>
        <p>{{item.name}}</p>
      </div>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
import {getSongList} from 'api/songlist'
export default {
  data() {
    return {
      lists: []
    }
  },
  created() {
    this._getSongList()
  },
  methods: {
    _getSongList() {
      getSongList().then((res) => {
        if(res.data.errorCode === 0) {
          this.lists = res.data.data;
          console.log(this.lists)
        }
      })
    },
    showDetail(item) {
      this.$router.push({
        path: `/myRecommend/${item.id}`,
        params: {id: item.id}
      })
    }
  }
}
</script>

<style>
.list-wrapper {
  font-size: 0;
}
.list-item {
  display: inline-block;
  width: 16.6%;
  box-sizing: border-box;
  padding: 10px; 
  cursor: pointer;
}
.list-item > img {
  width: 100%;
}
.list-item > p {
  font-size: 14px;
  color: #777;
  text-align: center;
  height: 40px;
  line-height: 40px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
</style>
