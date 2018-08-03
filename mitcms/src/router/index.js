import Vue from 'vue'
import Router from 'vue-router'
import Home from 'components/home/home'
import Recommend from 'components/recommend/recommend'
import MyRecommend from 'components/myRecommend/myRecommend'
import SongList from 'components/songlist/songlist'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      redirect: '/home'
    },
    {
      path: '/home',
      component: Home,
    },
    {
      path: '/recommend',
      component: Recommend
    },
    {
      path: '/myRecommend',
      component: MyRecommend,
      children: [
        {
          path: ':id',
          component: SongList
        }
      ]
    }
  ]
})
