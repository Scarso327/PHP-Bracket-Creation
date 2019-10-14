<?php
class Tournament {

    public static $teams;
    public static $winner = -1;

    /*
    ** $tournament = Array (Contains Tournament Details (Results, Etc)) (Required)
    ** $sepWinner = Boolean (Tells us whether to display the winner seperately at the end) (Optional)
    */
    public function __construct($tournament, $showWinner = false, $onlyShowWhenFinished = false) {
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
                                <?php echo self::renderStage($stage, (array_key_last($bracket) == $key)); ?>
                            </div>
                        </div>
                        <?php
                    }

                    if ($showWinner && ($onlyShowWhenFinished || self::$winner)) {
                        ?>
                        <div class="stage">
                            <h4>Winner</h4>
                            <div class="results">
                                <div class="result-block">
                                    <div id="team-<?=self::$winner;?>" class="team <?=(self::$winner != -1) ? 'winner' : '';?> finalWinner team-<?=self::$winner;?> <?=($result["winner"] == $key) ? 'winner' : ''; ?>">
                                        <div class="name"><?=(self::$winner == -1) ? 'TBD' : self::$teams[self::$winner];?></div>
                                        <div class="score">1st</div>
                                    </div>
                                </div>
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
                    var className = $(this).attr('id');
                    
                    if (className != "team--1") {
                        teamElements = document.getElementsByClassName(className);

                        for(var i=0; i < teamElements.length; i++) {
                            teamElements[i].style.background = "#e69138";
                        }
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

    public function renderStage($stage, $finalStage = false) {

        foreach($stage["results"] as $result) {
            ?>
            <div class="result-block">
                <?php
                foreach($result["teams"] as $key=>$team) {
                    ?>
                    <div id="team-<?=$team;?>" class="team team-<?=$team;?> <?=($result["winner"] == $key) ? 'winner' : ''; ?>">
                        <div class="name"><?=($team == -1) ? 'TBD' : self::$teams[$team];?></div>
                        <div class="score"><?=$result["scores"][$key];?></div>
                    </div>
                    <?php

                    if (array_key_last($result["teams"]) == $key && ($result["winner"] == $key) && $finalStage) {
                        self::$winner = $team;
                    }
                }
                ?>
            </div>
            <?php
        }
    }
}