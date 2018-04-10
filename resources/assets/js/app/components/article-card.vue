<template>
    <router-link :to="getRouteParams()" class="router-link white--text">
        <v-card>
            <v-card-media :src="bgImageUrl" :height="getCardImageHeight"/>
        </v-card>
        <!-- Title -->
        <div class="py-1">
            <span :class="getTitleClasses">{{ getTitle }}</span>
        </div>
    </router-link>
</template>

<script>
	export default {
		name    : "article-card",
		props   : {
			title     : {
				type    : String,
				required: true,
				default : '',
			},
			bgImageUrl: {
				type    : String,
				required: false,
			},
			articleId : {
				type    : Number,
				required: true,
			},
			xsHeight    : {
				type    : Number,
				required: false,
				default : 200,
			},
		},
		computed: {
			getTitle () {
				return this.title[ 0 ].toUpperCase() + this.title.slice( 1 );
			},
			getTitleClasses () {
				return this.getTitleSizeClass();
			},
			getCardImageHeight() {
				return this.getImageSizeByBreakPoint();
            }
		},
		methods : {
			getRouteParams () {
				return {
					name  : 'articles.single',
					params: { id: this.articleId },
				};
			},
			getTitleSizeClass () {
				let $sizeClass = '';

				switch (this.$vuetify.breakpoint.name) {
                    case "xl": {
                        $sizeClass = 'title';
                        break;
                    }
					case "lg": {
						$sizeClass = 'title';
						break;
					}
					case "md" : {
                    	$sizeClass = 'subheading';
						break;
					}
					case "sm" : {
						$sizeClass = 'subheading';
						break;
					}
					case "xs" : {
						$sizeClass = 'subheading';
						break;
					}
                    default: {
                    	$sizeClass = 'title';
                    }
				}

				return $sizeClass;
			},
			getImageSizeByBreakPoint(){
				let $size = 0;

				switch (this.$vuetify.breakpoint.name) {
					case "xl": {
						$size = this.xsHeight + 100;
						break;
					}
					case "lg": {
						$size = this.xsHeight + 75;
						break;
					}
					case "md" : {
						$size = this.xsHeight + 75;
						break;
					}
					case "sm" : {
						$size = this.xsHeight + 25;
						break;
					}
					case "xs" : {
						$size = this.xsHeight;
						break;
					}
					default: {
						$size = this.xsHeight;
					}
				}

				return $size + 'px';
            }
		},
	};
</script>