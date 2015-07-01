//session: Start from the latest requester's chat

//max number of chat can one worker propose at each session
var maxChatNum = 2;

//proportion to achieve agreement in chat voting
var consentProportion = 0.4;

//timeout workers are not included in the voting caculation
var workerTimeoutInSec = 5;

//timeout chats can not be accepted anymore
//for now it can still be voted, but they're just fake votes
var chatTimeoutInSec = 60*5;

//set timeout for TTS
var speechTimeoutInMiniSec = 250;

//each memory vote worth how many seconds  
var secondPerMemoryVote = 60*3;

