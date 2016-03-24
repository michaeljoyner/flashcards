@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="main-section flashcard-viewer">
        <flashcard :eng="current.eng"
                   :py="current.py"
                   :trad="current.trad"
                   :classification="current.classification.name"
                   v-show="counter % 2 == 0"
        ></flashcard>
        <flashcard :eng="nextinline.eng"
                   :py="nextinline.py"
                   :trad="nextinline.trad"
                   :classification="nextinline.classification.name"
                   v-show="counter % 2 !== 0"
        ></flashcard>
        <div class="classify-button-container">
            <div class="classify-btn all" v-on:click="showAll" :class="{'showing': !classification}">All</div>
            <div class="classify-btn vocab" v-on:click="showVocab" :class="{'showing': classification == 'vocab'}">Voc</div>
            <div class="classify-btn phrase" v-on:click="showPhrases" :class="{'showing': classification == 'phrase'}">Phr</div>
            <div class="classify-btn sentence" v-on:click="showSentences" :class="{'showing': classification == 'sentence'}">Sen</div>
        </div>
        <button class="next-btn" v-on:click="showNext">Next</button>
    </section>
    <template id="flashcard-template">
        <div class="flashcard" transition="slide">
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
                counter: 0,
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

                nextinline: function() {
                    if ((this.list.length) > this.current_pos + 1) {
                        return this.list[this.current_pos + 1];
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

                    if(this.current_pos >= (this.list.length - 2)) {
                        return this.current_pos = 0;
                    }
                    this.counter++;
                    this.current_pos += 2;
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