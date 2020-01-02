<template>
    <div id="svg-container">
        <tree ref="tree" :identifier="getId" :zoomable="tree.zoomable" :data="tree.treeData" :node-text="tree.nodeText"  :margin-x="tree.Marginx" :margin-y="tree.Marginy" :radius="tree.radius" :type="tree.type" :layout-type="tree.layoutType" :duration="tree.duration" class="tree" @clicked="onClick" @expand="onExpand" @retract="onRetract"/>
        <person :current-node="tree.currentNode"></person>
    </div>

</template>

<script>
    import { mapState } from 'vuex'
    import {tree} from 'vued3tree'

    export default {
        name: 'Tree',
        components: {
            tree
        },
        mounted () {
            this.$store.dispatch('tree/getTree')
        },
        computed: {
            ...mapState({
                tree: state => state.tree
            })
        },
        methods: {
            onClick (evt) {
                this.onEvent('onClick', evt);
                this.$store.dispatch('tree/setCurrentNode', evt.element);
            },
            do (action) {
                if (this.tree.currentNode) {
                    this.$store.dispatch('tree/setLoading', true);
                    this.$refs['tree'][action](this.tree.currentNode).then(() => { this.$store.dispatch('tree/setLoading', false) })
                }
            },
            getId (node) {
                return node.id
            },
            expandAll () {
                this.do('expandAll')
            },
            collapseAll () {
                this.do('collapseAll')
            },
            showOnly () {
                this.do('showOnly')
            },
            show () {
                this.do('show')
            },
            onExpand (evt) {
                this.onEvent('onExpand', evt)
            },
            onRetract (evt) {
                this.onEvent('onRetract', evt)
            },
            onEvent (eventName, data) {
                this.$store.dispatch('tree/appendEvent', {eventName, data: data.data});
            },
            resetZoom () {
                this.$store.dispatch('tree/setLoading', true);
                this.$refs['tree'].resetZoom().then(() => { this.$store.dispatch('tree/setLoading', false) })
            }
        }
    }
</script>

<style scoped>
    .tree {
        height: 85vh;
        width: 100%;
    }
</style>
