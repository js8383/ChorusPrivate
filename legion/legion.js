var pointsPerDollar = 50000; // Default: 120k? 200k?
var pointMapping = {
    "vote": 20,
    "voted_for_accepted": 1000,
    "message": 100,
    "message_accepted": 3000,
    "message_solo_accepted": 1200,
    "highlight": 30,
    "highlight_like": 10,
    "abstain": 10,
    //"punish_vote": -1000,
    //"punish_post": -3000
};

var _score = 0;

//set to 0.01 for demo only, should be 0.02
var min_money = 0.02;

//set to 200 for demo only, should be 1100
var minSubmitScore = 1100;

var pointRecord = {};

function initPointRecord() {
    for (x in pointMapping) {
        pointRecord[x] = 1;
    }
}

function legion_reset_actions() {
    initPointRecord();
}
initPointRecord();

function legion_reward(action, element) {
    //if( gup('role') == "requester" ) { return; }

    if (pointMapping[action]) {
        if (action != "abstain" && action != "punish_post" && action != "punish_vote") { // && action!="vote"){
            var scoreIncrement = Math.floor(pointMapping[action] / pointRecord[action]);

            pointRecord[action] *= 3;
        } else {
            if (action == "punish_post" || action == "punish_vote") {
                var scoreIncrement = pointMapping[action];
            } else if (action == "abstain") {
                var scoreIncrement = parseInt($("#votes-allowed").text()) * 5;
            }
        }

        if (typeof(element) == undefined) {
            _score += scoreIncrement;
            updateScore();
            if (_score >= minSubmitScore) {
                $('#legion-submit').removeAttr('disabled');
            }

        } else {

            // animate the points coming out of it

            var curr_x = $(element).offset().left + Math.floor($(element).width() / 2);
            var curr_y = $(element).offset().top + Math.floor($(element).height() / 2);

            var c = $("<div>" + scoreIncrement + "</div>");
            c.width(150);

            c.css('position', 'absolute');
            c.offset({
                top: curr_y,
                left: curr_x
            });

            if (action == "punish_vote" || action == "punish_post") {
                c.addClass('legion-score-display-r');
            } else {
                c.addClass('legion-score-display-a');
            }
            c.css('opacity', 0.0);

            $(document.body).append(c);

            var dest_x = $("#legion-points").offset().left;
            var dest_y = $("#legion-points").offset().top;

            var diff_x = dest_x - curr_x;
            var diff_y = dest_y - curr_y;

            $(c).animate({
                top: ((diff_y < 0) ? "-=" : "+=") + Math.abs(diff_y),
                opacity: 1.0
            }, 1600, function() {
                c.css('width', 'auto');
                $(c).animate({
                    opacity: 0.5,
                    left: ((diff_x < 0) ? "-=" : "+=") + Math.abs(diff_x)
                }, {
                    duration: 1200,
                    complete: function() {
                        c.remove();
                        _score += scoreIncrement;
                        updateScore();
                        if (_score >= minSubmitScore) {
                            $('#legion-submit').removeAttr('disabled');
                        }
                    },
                    step: function(now, fx) {
                        if (fx.prop == "opacity") {
                            /*var offset = (now - fx.start);
                              var range = (fx.end - fx.start);
                              
                              var frac = offset / range;
                              var abs = (1 / children);
                              var val = Math.floor(frac / abs);
                              
                              for(var i=score_add.length-val; i<score_add.length; i++) {
				              _score += score_add[i];
				              score_add[i] = 0;
                              }
                              updateScore();*/
                        }
                    }
                });
            });
        }
    }
}

//  Turkify the page.
$(document).ready(function() {
    ///////////////////////////////////////////////////////////////////////////////////////////////
    // NOTE: THIS IS JUST TEMP UNTIL /retainer/scripts/getMoneyOwed.js is fixed from using async //
    /*Kenneth 20140807: Just remove this for CHI 2015
    $.ajax({
    	//url: "/Chorus/retainer/php/getTimeWaited.php",
    	//
    	//alert("legion.js");
    	url: "../retainer/php/getTimeWaited.php",
    	data: {workerId: gup('workerId')},
                                    dataType: "text",
                                    success: function(d) {
                                            //
                                            //alert("d: " + d)
                                            waitMoney = Math.round(.02 * d/60.0 * 100.0)/100.0; //assuming 2 cents/min
    					if( waitMoney > 0 ) {
    						alert("Thanks for waiting! You will be paid an ADDITIONAL $" + waitMoney + " bonus if you work on this task immediately.")
    					}
                                    },
                            fail: function() {
                                    alert("setLive failed!")
                            },
            });
    */
    // END NOTE //
    /////////////

    //if(true){
    //if(role == "crowd"){
    //	$('#legion-submit').attr('disabled', 'disabled');
    //	$('#sidebar').prepend($('<div id="legion-score"><span id="legion-instructions-top" class="legion-instructions">You have earned ~$<span id="legion-money">0.00</span></span><br/><span class="legion-points" id="legion-points">--</span><br/><span id="legion-instructions-bottom" class="legion-instructions">(depending on quality check)</span></div>'));
    //}else{
    //	$('#sidebar').remove();
    //	$('#legion-submit').remove();
    //}

    if (gup("assignmentId") != "") {
        // create form
        //$('#instructions').append($('<div id="legion-submit-div"><p id="legion-submit-instructions">The HIT is now over. Please submit it for payment. If the button below is disabled, then you did not accumulate enough money to be paid.</p><form id="legion-submit-form"><input type="hidden" name="money" value="0" id="legion-money-field"><input type="hidden" name="assignmentId" id="legion-assignmentId"><input id="legion-submit" type="button" value="Submit HIT"></div>'));

        var jobkey = gup("assignmentId");
        if (gup("hitId") != "") {
            jobkey += "|" + gup("hitId");
        }

        if (gup("assignmentId") == "ASSIGNMENT_ID_NOT_AVAILABLE") {
            $('input').attr("DISABLED", "true");
            _allowSubmit = false;
        } else {
            _allowSubmit = true;
        }
        $('#legion-assignmentId').attr('value', gup("assignmentId"));
        $("#legion-submit-form").attr('method', 'POST');


        if (gup("turkSubmitTo") != "") {
            $("#legion-submit-form").attr('action', gup("turkSubmitTo") + '/mturk/externalSubmit');
        }

        //$('#legion-submit').removeAttr('disabled');
        $("#legion-submit").click(submitToTurk);
    } else {
        //alert("not unlocking:: " + gup("assignmentId"))
    }
});


function submitToTurk(ev) {

    waitMoney = 1;
    var m = (Math.ceil(parseFloat($("#legion-money").text()) * 100.00) / 100.00) * waitMoney;
    alert('Your HIT is being submitted. A quality check will be performed on your work, and you will be paid up to $' + m + ' bonus based on the results. Generally, payments are processed within one hour.');
    //alert('Your HIT is being submitted!');
    //alert("worker ID: "+worker);

    if (typeof ev != "undefined") {
        ev.preventDefault();
    }

    //Kenneth: 20140806, dirty hack. Hope it works..
    //postBonus(m);

    $("#legion-submit-form").submit();

    return false;
}

function postBonus(bonusMoney) {

    $.ajax({
        type: 'POST',
        async: false,
        url: 'postBonus.php',
        //url: 'Retainer/php/processHIT.php',
        data: {
            //$('form').serialize(),
            id: gup("assignmentId"),
            workerId: worker,
            amount: bonusMoney,
            useSandbox: true
        },
        success: function(d) {
            // alert( $('form').serialize());
            //console.log(d);
            //if(d == "True"){
            //  $("#bonusedHistory").append($("#workerId").val() + " : $" + $("#bonusAmount").val() + "</br>");
            //}
            //else alert("Bonus failed");
        }
    });

}

function sendBonusMoney(bonusMoney) {

    //alert(gup("assignmentId"));
    $.ajax({
        type: 'POST',
        async: false,
        url: '../../LegionTools/Retainer/php/processHIT.php',
        //url: 'Retainer/php/processHIT.php',
        data: {
            //$('form').serialize(),
            id: gup("assignmentId"), //assign ID or HIT id
            operation: "Bonus",
            reason: "Good work! (test)",
            workerId: worker,
            amount: bonusMoney,
            useSandbox: true
        },
        success: function(d) {
            // alert( $('form').serialize());
            //console.log(d);
            //if(d == "True"){
            //  $("#bonusedHistory").append($("#workerId").val() + " : $" + $("#bonusAmount").val() + "</br>");
            //}
            //else alert("Bonus failed");
        }
    });


}

function autoApproveHIT() {
    $.ajax({
        type: 'POST',
        url: auto_approve_url,
        data: "a=" + gup("assignmentId"),
        success: function() {
            setTurkMessage("message_approved");
            autoApproveHIT();
        },
        error: function() {
            setTurkMessage("message_error");
        }
    });
}


function setTurkMessage(id) {
    $("#submission_results .messages").hide();
    $("#" + id).show();
}

function updateScore() {
    $("#legion-points").html(Math.floor(_score));
    var m = Math.round(((_score / pointsPerDollar)) * 1000.0) / 1000.0;
    if (!/\./.test(m)) {
        m += ".000";
    } else if (/\.\d\d$/.test(m)) {
        m += "0";
    } else if (/\.\d$/.test(m)) {
        m += "00";
    }
    $("#legion-money").html(m);
    $("#legion-money-field").attr('value', m);

    if (parseFloat(m) > min_money) {
        $("#legion-submit").removeAttr("DISABLED");
    }
}
