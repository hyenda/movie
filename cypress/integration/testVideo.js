describe('test video', () => {
    it('play one of the videos', () => {
        cy.visit('http://localhost/lazy_sun/index.php')
        cy.get('.card:nth-child(1) > a').click()
        cy.get('.video-container > video', { timeout: 10000 })
        .should('have.prop', 'paused', true)
        .then(($video) => {
            $video[0].play()
        })

        cy.get('.video-container > video')
        .should('have.prop', 'paused', false)

    })
})