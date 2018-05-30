<template>
    <div id="svg-container">
        <tree ref="tree" :identifier="getId" :zoomable="zoomable" :data="treeData" :node-text="nodeText"  :margin-x="Marginx" :margin-y="Marginy" :radius="radius" :type="type" :layout-type="layoutType" :duration="duration" class="tree" @clicked="onClick" @expand="onExpand" @retract="onRetract"/>
        <div class="modal fade" id="personInfoModal" tabindex="-1" role="dialog" aria-labelledby="personInfoModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fullName">{{ currentNode ? currentNode.data.full_name : null }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {tree} from 'vued3tree'
    import {data} from './data'

    export default {
        name: 'app',
        data () {
            return {
                type: 'tree',
                layoutType: 'euclidean',
                duration: 750,
                Marginx: 30,
                Marginy: 30,
                radius: 5,
                nodeText: 'full_name',
                currentNode: null,
                zoomable: true,
                isLoading: false,
                events: [],
                treeData: null
            }
        },
        components: {
            tree
        },
        mounted () {
            data().then(response => {
                this.treeData = response.data;
            });
        },
        methods: {
            do (action) {
                if (this.currentNode) {
                    this.isLoading = true;
                    this.$refs['tree'][action](this.currentNode).then(() => { this.isLoading = false })
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
            onClick (evt) {
                this.currentNode = evt.element;
                this.onEvent('onClick', evt);

                $('#personInfoModal').modal();
            },
            onExpand (evt) {
                this.onEvent('onExpand', evt)
            },
            onRetract (evt) {
                this.onEvent('onRetract', evt)
            },
            onEvent (eventName, data) {
                this.events.push({eventName, data: data.data});
                console.log({eventName, data: data})
            },
            resetZoom () {
                this.isLoading = true;
                this.$refs['tree'].resetZoom().then(() => { this.isLoading = false })
            }
        }
    }
</script>

<style>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 20px;
    }

    .tree {
        height: 600px;
        width: 100%;
    }

    .graph-root {
        height: 800px;
        width: 100%;
    }

    .log  {
        height: 500px;
        overflow-x: auto;
        overflow-y: auto;
        overflow: auto;
        text-align: left;
    }

</style>
