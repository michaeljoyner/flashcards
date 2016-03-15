@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="main-section flashcard-viewer" :class="{'shrink': transitioning}">
        <flashcard :eng="current.eng"
                   :py="current.py"
                   :trad="current.trad"
        ></flashcard>
        <button class="next-btn" v-on:click="showNext">Next</button>
    </section>
    <template id="flashcard-template">
        <div class="flashcard">
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

            props: ['eng', 'py', 'trad']
        });

        var bank = new Vue({
            el: 'body',

            data: {
                list: [],
                current_pos: 0,
                transitioning: false
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
                                this.$set('list', res.data);
                            })
                            .catch(function (res) {
                                console.log(res);
                            });
                }
            }
        });
    </script>
@endsection