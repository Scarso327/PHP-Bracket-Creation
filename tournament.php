<?php
class Tournament {

    public static $teams;

    public function __construct($tournament) {
        self::$teams = $tournament["teams"];

        ?>
        <div class="brackets container">
            <?php
            foreach ($tournament["Brackets"] as $key=>$bracket) {
                ?>
                <h4><?=$key;?></h4>
                <div class="bracket">
                    <?php
                    foreach ($bracket as $key=>$stage) {
                        ?>
                        <div class="stage">
                            <h4><?=$stage["name"];?></h4>
                            <div class="results">
                                <?php echo self::renderStage($stage); ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <script>
            var teamElements;

            $(".team").hover(
                function() {
                    console.log($(this).attr('id'));
                    teamElements = document.getElementsByClassName($(this).attr('id'));

                    for(var i=0; i < teamElements.length; i++) {
                        teamElements[i].style.background = "#e69138";
                    }
                }, 
                function() {
                    for(var i=0; i < teamElements.length; i++) {
                        teamElements[i].style.background = "";
                    }
                }
            );
            </script>
        </div>
        <?php
    }

    public function renderStage($stage) {

        foreach($stage["results"] as $result) {
            ?>
            <div class="result-block">
                <?php
                foreach($result["teams"] as $key=>$team) {
                    ?>
                    <div id="team-<?=$team;?>" class="team team-<?=$team;?> <?=($result["winner"] == $key) ? 'winner' : ''; ?>">
                        <div class="name"><?=self::$teams[$team];?></div>
                        <div class="score"><?=$result["scores"][$key];?></div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
}