<template>
    <div ref=wrapper>
        <slot></slot>
    </div>
</template>

<script>
    import BScroll from 'better-scroll'
    export default {
      name: 'scroll',
      props: {
        click: {
          type: Boolean,
          default: true
        },
        data: {
          type: Array,
          default: null
        },
        listenScroll: {
          type: Boolean,
          default: false
        },
        BeforeScroll: {
          type: Boolean,
          default: false
        },
        hasBar: {
          type: Boolean,
          default: true
        },
        probeType: {
          type: Number,
          default: 3
        },
        pullup: {
          type: Boolean,
          default: false
        }
      },
      mounted() {
        setTimeout(() => {
          this._initScroll()
        })
      },
      methods: {
        scrollTo() {
          this.Bscroll && this.Bscroll.scrollTo.apply(this.Bscroll, arguments)
        },
        scrollToElement() {
          this.Bscroll && this.Bscroll.scrollToElement.apply(this.Bscroll, arguments)
        },
        _initScroll(){

          let scrollBar = null
          if(this.hasBar) {
            scrollBar = {
              fade: true,
              interactive: false // 1.8.0 新增
            }
          }

          this.Bscroll = new BScroll(this.$refs.wrapper,{
            click: this.click,
            probeType: this.probeType,
            scrollbar: scrollBar,
            mouseWheel: {
              speed: 20,
              invert: false
            }
          })

          if(this.listenScroll) {
            this.Bscroll.on('scroll',(pos) => {
              this.$emit('scroll',pos)
            })
          }
          if(this.pullup) {
            this.Bscroll.on('scrollEnd',() => {
                if(this.Bscroll.y <= this.Bscroll.maxScrollY + 50) {
                  this.$emit('scrollToEnd')
                }
            })
          }

          if(this.BeforeScroll) {
            this.Bscroll.on('beforeScrollStart',() => {
              this.$emit('beforeScroll')
            })
          }
        },
        refresh() {
          this.Bscroll && this.Bscroll.refresh()
        }
      },
      watch: {
        data(newData) {
          this.Bscroll.refresh()
        }
      }
    }
</script>

<style>

</style>