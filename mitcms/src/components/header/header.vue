<template>
  <div>
    <el-menu
      :default-active="activeIndex"
      class="el-menu-demo"
      mode="horizontal"
      background-color="#545c64"
      text-color="#fff"
      active-text-color="#ffd04b">
      <el-menu-item index="1">
        <router-link to="/home">HOME</router-link>
      </el-menu-item>

      <el-submenu index="2">
        <template slot="title">RECOMMEND</template>
        <el-menu-item index="2-1">
          <router-link to="/myRecommend" tag="div">我的推荐</router-link>
        </el-menu-item>
        <el-menu-item index="2-2">
          <router-link to="/recommend" tag="div">推荐歌单</router-link>
        </el-menu-item>
      </el-submenu>
      <!-- <el-submenu index="2">
        <template slot="title">我的工作台</template>
        <el-menu-item index="2-1">选项1</el-menu-item>
        <el-menu-item index="2-2">选项2</el-menu-item>
        <el-menu-item index="2-3">选项3</el-menu-item>
        <el-submenu index="2-4">
          <template slot="title">选项4</template>
          <el-menu-item index="2-4-1">选项1</el-menu-item>
          <el-menu-item index="2-4-2">选项2</el-menu-item>
          <el-menu-item index="2-4-3">选项3</el-menu-item>
        </el-submenu>
      </el-submenu> -->
      <el-menu-item index="3" disabled>TEST</el-menu-item>
    </el-menu>
    <div class="userinfo" v-if="userinfo">
      <img :src="userinfo.avatar">
      <i class="iconfont icon-denglulogin10" @click="exit"></i>
    </div>
  </div>
</template>

<script>
import {clearToken} from 'common/js/token'
export default {
  props: {
    userinfo: {
      type: Object,
      default: null
    }
  },
  mounted(){
    console.log(this.userinfo)
  },
  data() {
    return {
      activeIndex: '1'
    }
  },
  methods: {
    exit() {
      this.$confirm('要退出吗？', '提示').then(() => {
        clearToken()
        this.$emit('logout')
      })
    }
  }
}
</script>

<style>
.el-menu-item > a {
  display: block;
  width: 100%;
  height: 100%;
  text-decoration: none;
}
.userinfo {
  position: absolute;
  right: 0;
  top: 10px;
  padding-right: 20px;
}

.userinfo > img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  vertical-align: middle;
}

.userinfo > i {
  font-size: 20px;
  color: #fff;
  vertical-align: middle;
  margin-left: 10px;
  cursor: pointer;
}
</style>
