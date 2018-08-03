import Vue from 'vue'
import Router from 'vue-router'
import SongList from 'components/songList/songList'
import Singer from 'components/singer/singer'
import SingerDetail from 'components/singerDetail/singerDetail'
import Rank from 'components/Rank/Rank'
import RankDetail from 'components/RankDetail/RankDetail'
import Recommend from 'components/Recommend/Recommend'
import RecommendDetail from 'components/RecommendDetail/RecommendDetail'
import UserListDetail from 'components/UserListDetail/UserListDetail'
import Forum from 'components/forum/forum'
import ForumDetail from 'components/forumDetail/forumDetail'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      redirect: '/songList'
    },
    {
      path: '/songList',
      component: SongList
    },
    {
      path: '/singer',
      component: Singer,
      children: [
        {
          path: ':id',
          component: SingerDetail
        }
      ]
    },
    {
      path: '/rank',
      component: Rank,
      children: [
        {
          path: ':id',
          component: RankDetail
        }
      ]
    },
    {
      path: '/recommend',
      component: Recommend,
      children: [
        {
          path: ':id',
          component: RecommendDetail
        }
      ]
    },
    {
      path: '/userListDetail/:id',
      component: UserListDetail
    },
    {
      path: '/forum',
      component: Forum,
      children: [
        {
          path: ':id',
          component: ForumDetail
        }
      ]
    }
  ]
})
