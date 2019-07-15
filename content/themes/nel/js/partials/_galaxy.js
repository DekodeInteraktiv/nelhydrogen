(function ($, document, window, undefined) {

    $.fn.galaxy = function (options) {

        var $window = $(window)

        var settings = {
            speed: 5,
            color: 0x000000
        }
        $.extend(settings, options)

        return this.each(function () {

            var $instance = $(this),
                THREE,
                camera, scene, renderer, particles = [],
                particleSpeed = settings.speed,
                particleTimer

            function initStars () {

                camera = new THREE.PerspectiveCamera(80, $instance.width() / $instance.height(), 1, 4000)
                camera.position.z = 1000
                scene = new THREE.Scene()
                scene.add(camera)
                renderer = new THREE.CanvasRenderer()
                renderer.setSize($instance.width(), $instance.height())
                $instance[0].appendChild(renderer.domElement)
                makeParticles()
                particleTimer = setInterval(update, 1000 / 30)

                // init particles
                $instance.addClass('galaxy-init').trigger('init')

            }

            function update () {

                updateParticles()
                renderer.render(scene, camera)

            }

            function getRandomInt (min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min
            }

            function makeParticles () {

                var particle, material

                for (var zpos = -1000; zpos < 1000; zpos += 5) {

                    // create flimmer effect
                    material = new THREE.ParticleCanvasMaterial({
                        color: settings.color,
                        program: particleRender
                    })

                    particle = new THREE.Particle(material)
                    particle.position.x = Math.random() * 1000 - 500
                    particle.position.y = Math.random() * 1000 - 500
                    particle.position.z = zpos
                    particle.scale.x = particle.scale.y = 1
                    scene.add(particle)
                    particles.push(particle)

                }

            }

            function particleRender (context) {
                context.beginPath()
                context.arc(0, 0, 2, 0, Math.PI * 2, true)
                context.fill()
            }

            function updateParticles () {

                for (var i = 0; i < particles.length; i++) {

                    var particle = particles[i]
                    particle.position.z += particleSpeed

                    if (getRandomInt(0, 1) === 0) {
                        //particle.scale.x = particle.scale.y = 0;
                    } else {
                        //particle.scale.x = particle.scale.y = 1;
                    }

                    if (particle.position.z > 1000) {

                        particle.position.z -= 2000

                    }

                }

            }

            function updateRendererSize () {
                if (camera) {
                    camera.aspect = $instance.width() / $instance.height()
                    camera.updateProjectionMatrix()
                    renderer.setSize($instance.width(), $instance.height())
                }
            }

            /*
            LISTENERS
            */

            $window.on('resize', window.nel.utils.throttle(updateRendererSize, 100))

            $instance.on('setSpeed', function (event, speed) {
                particleSpeed = speed
            })

            $instance.on('pause', function () {
                clearInterval(particleTimer)
            })

            $instance.on('play', function () {
                if (particleTimer) {
                    clearInterval(particleTimer)
                }
                particleTimer = setInterval(update, 1000 / 30)
            })

            /*
            INIT
            */

            function init_galaxy () {

                THREE = window.THREE

                initStars()

            }

            function init_galaxy_failed (data, status, jqxhr) {
                window.console.log('failed loading threejs', data, status, jqxhr)
            }

            /*
            LOAD THREE.js
            */
            $.ajax({
                url: window.data.scripts.threejs,
                dataType: 'script',
                cache: true
            })
                .done(init_galaxy)
                .fail(init_galaxy_failed)

        })

    }

})(jQuery, document, window)