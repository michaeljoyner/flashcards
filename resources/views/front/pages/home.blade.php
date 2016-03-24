@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="main-section flashcard-viewer" :class="{'shrink': transitioning}">
        <flashcard :eng="current.eng"
                   :py="current.py"
                   :trad="current.trad"
                   :classification="current.classification.name"
        ></flashcard>
        <div class="classify-button-container">
            <div class="classify-btn all" v-on:click="showAll" :class="{'showing': !classification}">Aa</div>
            <div class="classify-btn vocab" v-on:click="showVocab" :class="{'showing': classification == 'vocab'}">Vv</div>
            <div class="classify-btn phrase" v-on:click="showPhrases" :class="{'showing': classification == 'phrase'}">Pp</div>
            <div class="classify-btn sentence" v-on:click="showSentences" :class="{'showing': classification == 'sentence'}">Ss</div>
        </div>
        <button class="next-btn" v-on:click="showNext">Next</button>
    </section>
    <template id="flashcard-template">
        <div class="flashcard">
            <span class="classification-indicator">@{{ classification }}</span>
            <p class="flashcard-trad">@{{ trad }}</p>
            <p class="flashcard-py">@{{ py }}</p>
            <p class="flashcard-eng">@{{ eng }}</p>
        </div>
    </template>
@endsection

@section('bodyscripts')
    <script>
        Vue.component('flashcard', {
            template: '#flashcard-template',

            props: ['eng', 'py', 'trad', 'classification']
        });

        var bank = new Vue({
            el: 'body',

            data: {
                core_list: [],
                current_pos: 0,
                transitioning: false,
                classification: false,
            },

            computed: {
                current: function () {
                    if ((this.list.length) > this.current_pos) {
                        return this.list[this.current_pos];
                    }

                    return {
                        eng: '',
                        py: '',
                        trad: ''
                    }
                },

                list: function() {
                    var self = this;
                    if(! this.classification) {
                        return this.core_list;
                    }
                    return this.core_list.filter(function(flashcard) {
                        return flashcard.classification.name === self.classification;
                    });
                }
            },

            ready: function () {
                this.fetchWords();
            },

            methods: {
                showNext: function () {
                    var self = this;
                    this.transitioning = true;
                    window.setTimeout(function() {
                        self.transitioning = false;
                    }, 600);
                    if(this.current_pos >= (this.list.length - 1)) {
                        return this.current_pos = 0;
                    }

                    this.current_pos++;
                },

                fetchWords: function () {
                    this.$http.get('/api/words')
                            .then(function (res) {
                                this.$set('core_list', res.data);
                            })
                            .catch(function (res) {
                                console.log(res);
                            });
                },

                showVocab: function() {
                    this.classification = 'vocab';
                    this.checkPostion();
                },

                showPhrases: function() {
                    this.classification = 'phrase';
                    this.checkPostion();
                },

                showSentences: function() {
                    this.classification = 'sentence';
                    this.checkPostion();
                },

                showAll: function() {
                  this.classification = false;
                },

                checkPostion: function() {
                    if(this.current_pos >= this.list.length) {
                        this.current_pos = 0;
                    }
                }
            }
        });
    </script>
@endsection