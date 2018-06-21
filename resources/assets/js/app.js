function main() {

    if (window.location.href.indexOf("bets") > -1) {
        var bet_id = document.querySelector("#bet_id").value;
    }

    if (window.location.href.indexOf("games") > -1 || window.location.href.indexOf("bets") > -1) {
        let game_id = document.querySelector("#game_id").value;

        let aPlusButton = document.querySelector("#teamAplus");
        let aMinusButton = document.querySelector("#teamAminus");
        let bPlusButton = document.querySelector("#teamBplus");
        let bMinusButton = document.querySelector("#teamBminus");

        let aLabel = document.querySelector("#aScore");
        let bLabel = document.querySelector("#bScore");

        let aScore = parseInt(aLabel.innerHTML);
        let bScore = parseInt(bLabel.innerHTML);

        try {
            let submitButton = document.querySelector("#newbetsubmit");
            submitButton.addEventListener('click', (el) => {
                console.log(game_id);
                let csrf = document.querySelector("meta[name='csrf-token']").getAttribute('content');
                el.preventDefault();
                let data = {
                    a: aLabel.innerHTML,
                    b: bLabel.innerHTML,
                    game_id: game_id
                }

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/bets/add');
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                xhr.setRequestHeader("content-type", "application/json");
                xhr.send(JSON.stringify(data));

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200)
                            window.location.replace("/");
                    }
                }
            });
        } catch (e) {
        }

        try {
            let editsubmitButton = document.querySelector("#editbetsubmit");
            editsubmitButton.addEventListener('click', (el) => {
                console.log(game_id);
                let csrf = document.querySelector("meta[name='csrf-token']").getAttribute('content');
                el.preventDefault();
                let data = {
                    a: aLabel.innerHTML,
                    b: bLabel.innerHTML
                }

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/bets/edit/' + bet_id);
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                xhr.setRequestHeader("content-type", "application/json");
                xhr.send(JSON.stringify(data));

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200)
                            window.location.replace("/");
                    }
                }
            });
        } catch (e) {
        }

        aPlusButton.addEventListener('click', (el) => {
            aScore += 1;
            updateScores(aScore, bScore);
        });

        aMinusButton.addEventListener('click', (el) => {
            aScore -= 1;
            updateScores(aScore, bScore);
        });

        bPlusButton.addEventListener('click', (el) => {
            bScore += 1;
            updateScores(aScore, bScore);
        });

        bMinusButton.addEventListener('click', (el) => {
            bScore -= 1;
            updateScores(aScore, bScore);
        });

        function updateScores(a, b) {
            aLabel.innerHTML = a;
            bLabel.innerHTML = b;
        }
    }

    let bet_displays = document.getElementsByClassName("bet_display");

    for (let i = 0; i < bet_displays.length; i++) {
        bet_displays[i].addEventListener('click', (e) => {
            let bet_id = bet_displays[i].getAttribute("data-bet_id")
            window.location.replace("/bets/" + bet_id);
        });
    }

}


window.onload = main;
