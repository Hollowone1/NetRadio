<script>
import EnDirect from "@/components/EnDirect.vue";

export default {
  components: {
    EnDirect,
  },
}

</script>

<template>
  <main>
    <en-direct></en-direct>

    <section class="si-direct">
      <div class="si-direct-titre">
        <h2>En direct</h2>
        <embed src="/icons/direct.svg"/>
      </div>
      <div class="si-direct-infos">
        <embed src="/icons/Desktop.png"/>
        <div class="si-direct-infos-texte">
          <h3>Nom de l'émission</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Et magnam optio iusto, eaque quos impedit hic
            perferendis eius similique a maxime dolor unde fugiat facere, placeat vel ab expedita exercitationem.
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Et magnam optio iusto, eaque quos impedit hic
            perferendis eius similique a maxime dolor unde fugiat facere, placeat vel ab expedita exercitationem.
          </p>
        </div>
      </div>
    </section>

    <section class="podcasts-emission">
      <h2>Podcasts</h2>
      <div class="episodes">
        <section class="episode">
          <div class="episode-infos">
            <div>
              <embed class="play" src="/icons/miniplay.svg">
              <p class="titre">Nom de l'épisode</p>
            </div>
            <div>
              <p>00:00</p>
              <embed class="plus" src="/icons/plus.svg">
            </div>
            <!--<embed class="croix" src="/icons/croix.svg">-->
          </div>
          <div class="episode-infos-plus">
            <p><strong>Présentateur : </strong> Nom Prénom</p>
            <p><strong>Invités : </strong> Nom Prénom, Nom Prénom</p>
            <p class="date">00/00/0000</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
              dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
              ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
              laboris nisi ut aliquip ex ea commodo consequat. </p>
          </div>
        </section>

        <section class="episode">
          <div class="episode-infos">
            <div>
              <embed class="play" src="/icons/miniplay.svg">
              <p class="titre">Nom de l'épisode</p>
            </div>
            <div>
              <p>00:00</p>
              <embed class="plus" src="/icons/plus.svg">
            </div>
            <!--<embed class="croix" src="/icons/croix.svg">-->
          </div>
          <div class="episode-infos-plus">
            <p><strong>Présentateur : </strong> Nom Prénom</p>
            <p><strong>Invités : </strong> Nom Prénom, Nom Prénom</p>
            <p class="date">00/00/0000</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
              dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
              ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
              laboris nisi ut aliquip ex ea commodo consequat. </p>
          </div>
        </section>

        <section class="episode">
          <div class="episode-infos">
            <div>
              <embed class="play" src="/icons/miniplay.svg">
              <p class="titre">Nom de l'épisode</p>
            </div>
            <div>
              <p>00:00</p>
              <embed class="plus" src="/icons/plus.svg">
            </div>
            <!--<embed class="croix" src="/icons/croix.svg">-->
          </div>
          <div class="episode-infos-plus">
            <p><strong>Présentateur : </strong> Nom Prénom</p>
            <p><strong>Invités : </strong> Nom Prénom, Nom Prénom</p>
            <p class="date">00/00/0000</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
              dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
              ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
              laboris nisi ut aliquip ex ea commodo consequat. </p>
          </div>
        </section>
      </div>
    </section>
    <a href="emission.html">Découvrir d'autres émissions</a>
  </main>
</template>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";
@import "@/assets/listeEmissionsPodcasts";


.podcasts-emission, .si-direct {
  padding: 1em
}

.si-direct {
  &-titre {
    h2, embed {
      display: inline-block;
    }

    h2 {
      @include text-style(1.8em, inherit, bold);
    }

    embed {
      height: 1em;
      margin-left: .5em;
    }
  }

  &-infos {
    embed {
      width: 100%;
      border-radius: 10px;
      margin-bottom: .5em;
    }

    &-texte {
      text-align: justify;

      h3 {
        margin-bottom: .2em;
        @include text-style(1.3em, inherit, 600);
      }
    }
  }
}

.podcasts-emission {
  h2 {
    @include text-style(1.8em, inherit, bold);
  }

  .episode {
    margin-bottom: 1em;
    padding: .7em 1em .7em 1em;
    border: 3px solid $purple;
    border-radius: 10px;

    &-infos {
      font-size: 1.1em;
      @include flex(row, nowrap, .2em, space-between, center);

      div {
        @include flex(row, nowrap, 1em, space-between, center);
      }

      embed {
        height: 1.7em;
      }

      .titre {
        @include text-style(inherit, inherit, 500);
      }

      &-plus {
        margin-top: .8em;
        display: none;

        p {
          margin-top: .5em;
        }

        .date {
          @include text-style(inherit, inherit, 200);
        }
      }
    }
  }
}


@media screen and (min-width: 700px) {
  .podcasts-emission, .si-direct {
    padding: 1.5em;
  }
  .si-direct {
    &-titre {
      h2 {
        @include text-style(2.3em, inherit, bold);
      }

      embed {
        height: 1.5em;
      }
    }

    &-infos {
      @include flex(row, nowrap, 1em, space-between, center);

      embed {
        width: 25vw;
      }

      &-texte {
        font-size: 1.1em;

        h3 {
          margin: 0 0 .2em;
          @include text-style(1.5em, inherit, 600);
        }
      }
    }
  }

  .podcasts-emission {
    h2 {
      @include text-style(2.3em, inherit, bold);
    }

    .episodes {
      @include grid(repeat(auto-fit, minmax(22em, 1fr)), auto, 1em, center, stretch);

      .episode {
        margin: 0;

        embed:hover {
          cursor: pointer;
        }

        &-infos {
          font-size: 1.1em;
          @include flex(row, nowrap, .2em, space-between, center);

          div {
            @include flex(row, nowrap, 1em, space-between, center);
          }

          &-plus {
            font-size: 1em;
            display: none;
            //passer en display:initial au clic
            margin-top: .8em;

            p {
              margin-top: .5em;
            }

            .date {
              @include text-style(inherit, inherit, 200);
            }
          }
        }
      }
    }

  }
}
</style>