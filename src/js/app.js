document.addEventListener("DOMContentLoaded", function(event) {

    let btnPreview = document.querySelectorAll('.sn-preview-btn')
    for(let i = 0; i < btnPreview.length; i++) {

        btnPreview[i].addEventListener('mouseenter', function () {

            let parentIcon = document.getElementById(this.getAttribute('data-js-svg'))
            if(parentIcon) {
                let svg = parentIcon.value

                if(svg.length) {

                    let div = document.createElement('div')
                    div.classList.add('sn-preview-content')
                    div.innerHTML = svg

                    this.parentNode.insertBefore(div, this.nextSibling)
                }
            }
        })
        btnPreview[i].addEventListener('mouseleave', function () {

            let preview = this.parentNode.querySelector('.sn-preview-content')
            if(preview) {
                preview.remove()
            }
        })
    }

    let btnMenu = document.querySelectorAll('.sn-tab-menu-btn')
    for(let i = 0; i < btnMenu.length; i++) {
        btnMenu[i].addEventListener('click', function () {

            let showSection = document.getElementById(this.getAttribute('data-js-network')),
                toggleClass = 'is-visible',
                activeSection = document.querySelector(`.sn-tabs-body-network.${toggleClass}`),
                actifMenu = document.querySelector('.sn-tab-menu-btn.is-active')
            if(showSection && !showSection.classList.contains(toggleClass)) {

                if(activeSection) {
                    console.log(activeSection)
                    activeSection.classList.remove(toggleClass)
                }
                if(actifMenu) {
                    actifMenu.classList.remove('is-active')
                }

                showSection.classList.add(toggleClass)
                this.classList.add('is-active')
                window.history.pushState(null, window.title, this.getAttribute('data-href'))

            }
        })
    }

    let form = document.querySelectorAll('.sn-form')
    for(let i = 0; i < form.length; i++) {
        form[i].addEventListener('submit', function (event) {
            event.preventDefault()

            let submitBtn = this.querySelector('button[type=submit]'),
                form = this,
                xhr = new XMLHttpRequest(),
                progressIcon = this.querySelector(this.getAttribute('data-js-icon-progress')),
                toggleIconClass = 'is-visible'

            if(progressIcon) {
                progressIcon.classList.add(toggleIconClass)
            }

            submitBtn.disabled = true
            xhr.open('POST', form.getAttribute('action'))
            xhr.send(new FormData(form))

            xhr.onreadystatechange = function(event) {

                switch (this.readyState) {
                    case XMLHttpRequest.DONE:

                        const response = JSON.parse(this.responseText)

                        if(response.success) {

                            let validIcon = form.querySelector(form.getAttribute('data-js-icon-valid')),
                                tabMenu = document.getElementById(form.getAttribute('data-tab'))

                            if (validIcon) {
                                clearErrors()
                                validIcon.classList.add(toggleIconClass)
                                setTimeout(function () {
                                    validIcon.classList.remove(toggleIconClass)
                                }, 4000)
                            }

                            if (tabMenu && response.hasOwnProperty('data')) {

                                if (response.data.hasUrl) {
                                    tabMenu.classList.add('has-link')
                                } else {
                                    tabMenu.classList.remove('has-link')
                                }

                            }
                        } else {

                            clearErrors()

                            if(response.data.hasOwnProperty('errors')) {

                                const listErrors = response.data.errors
                                Object.keys(listErrors).forEach(fieldName =>  {

                                    let input = form.querySelector(`[name=${fieldName}]`)
                                    if(input) {
                                        let inputCol = input.parentNode.parentNode,
                                            fieldError = inputCol.querySelector('.sli-form-error')

                                        if(fieldError) {
                                            input.innerHtml = listErrors[fieldName]
                                        } else {

                                            let p = document.createElement('p')
                                            p.classList.add('sli-form-error')
                                            p.innerHTML = listErrors[fieldName]
                                            inputCol.append(p)
                                        }
                                    }
                                })

                            } else if(response.data.hasOwnProperty('msg')) {
                                alert(response.data.msg)
                            }
                        }

                        break;
                    case XMLHttpRequest.LOADING:
                        progressIcon.classList.remove(toggleIconClass)
                        submitBtn.disabled = false
                        break;
                }

            }

            function clearErrors() {
                form.querySelectorAll('.sli-form-error').forEach(error => {
                    error.remove()
                })
            }

        })
    }

    let fields = document.querySelectorAll('input.color-type')
    for(let i =0; i < fields.length; i++) {
        fields[i].oninput = function () {

            let value = this.value,
                previewEl = document.getElementById(this.getAttribute('data-js-preview'))

            if(previewEl) {
                if(value.length === 4 || value.length === 7) {
                     previewEl.style.background = value
                } else if(value.length === 0) {
                    previewEl.style.background = null
                }
            }
        }
    }

})