<template>
    <div class="wrapper">
        <span class="back" @click="back">Back</span>
        <div class="mainFloor clearfix">
            <div class="user">
                <img src="http://mit.api.com/uploads/face/20180322/7ebe17638d17103efa8bcf4ec1ef1642.jpg" alt="">
                <p class="name">路过一只大侠</p>
            </div>
            <h3 class="title">X21评测全面屏的进化，vivo X21冰钻黑图赏简评</h3>
            <p class="desc">2017年10月，vivo在居庸关长城用一部X20开启了全面屏新时代。仅仅6个月后，在互联网大咖们每年聚会的乌镇，vivo又推出了第二代全面屏新机——vivo X21。相比前代，X21不仅通过Notches屏进一步提升了屏占比，更采用了电镀金属中框+曲面玻璃背壳的全新设计语言，将整机的视觉效果和握持质感提升了一个段位。</p>
        </div>

        <div class="floor clearfix">
            <div class="user">
                <img src="http://mit.api.com/uploads/face/20180322/7ebe17638d17103efa8bcf4ec1ef1642.jpg" alt="">
                <p class="name">路过一只大侠</p>
            </div>

            <p class="desc">2017年10月，vivo在居庸关长城用一部X20开启了全面屏新时代。仅仅6个月后，在互联网大咖们每年聚会的乌镇，vivo又推出了第二代全面屏新机——vivo X21。相比前代，X21不仅通过Notches屏进一步提升了屏占比，更采用了电镀金属中框+曲面玻璃背壳的全新设计语言，将整机的视觉效果和握持质感提升了一个段位。</p>
        </div>
        <i class="replyButton iconfont icon-pinglun1" @click="commentVisible = true"></i>
        <el-dialog title="评论" :visible.sync="commentVisible" class="commentBox">
            <el-input
                    type="textarea"
                    :rows="5"
                    placeholder="自古评论出人才"
                    v-model="comment"
                    class="text"
            >

            </el-input>
            <el-button type="primary" @click="toComment">评论</el-button>
        </el-dialog>
    </div>
</template>

<script>
    export default {
      data() {
        return {
          commentVisible: false,
          comment: ''
        }
      },
      methods: {
        back() {
          this.$router.back()
        },
        toComment() {

        }
      }
    }
</script>

<style lang="stylus" scoped>
    .wrapper
        width: 100%
        height: 100%
        position: absolute
        top: 0
        left: 0
        background: #fff;
        .back
            position: absolute
            z-index: 1000
            right: 4px
            top: -40px
            font-size 19px
            cursor: pointer
        .mainFloor, .floor
            border-bottom: 2px solid #e4e7ed
            padding-bottom: 10px
            margin-bottom: 30px
            .user
                width: 100px
                margin-right: 10px
                float: left
                img
                    width: 100px
                    height: 100px
                    border: 1px solid #777
                    box-sizing border-box

                .name
                    font-size: 12px
                    line-height: 20px
                    text-align: center
            .title
                font-size: 16px
                margin-bottom: 10px
            .desc
                font-size: 14px
                line-height: 1.4
                color: #555
        .floor
            margin-bottom: 10px
            border-bottom: 1px dashed #e4e7ed
            .user
                width: 50px
                margin-right: 10px
                float: left
                img
                    width: 50px
                    height: 50px
        .replyButton
            position: absolute
            width: 40px
            height: 40px
            line-height: 40px
            font-size: 20px
            cursor: pointer
            right: 20px
            bottom: 20px
            border: 1px solid #777
            border-radius: 50%
            text-align center
            background: rgba(200, 200, 200, 0.6);
        .commentBox
            .text
                margin-bottom: 10px
</style>