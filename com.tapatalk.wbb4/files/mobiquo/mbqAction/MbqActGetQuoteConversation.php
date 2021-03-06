<?php

defined('MBQ_IN_IT') or exit;

MbqMain::$oClk->includeClass('MbqBaseActGetQuoteConversation');

/**
 * get_quote_conversation action
 * 
 * @since  2012-11-4
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqActGetQuoteConversation extends MbqBaseActGetQuoteConversation {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * action implement
     */
    public function actionImplement() {
        if (MbqMain::$oMbqConfig->moduleIsEnable('pc') && (MbqMain::$oMbqConfig->getCfg('pc.conversation')->oriValue == MbqBaseFdt::getFdt('MbqFdtConfig.pc.conversation.range.support'))) {
        } else {
            MbqError::alert('', "Not support module private conversation!", '', MBQ_ERR_NOT_SUPPORT);
        }
        $convId = MbqMain::$input[0];
        $msgId = MbqMain::$input[1];
        $oMbqRdEtPc = MbqMain::$oClk->newObj('MbqRdEtPc');
        if ($objsMbqEtPc = $oMbqRdEtPc->getObjsMbqEtPc(array($convId), array('case' => 'byConvIds'))) {
            $oMbqEtPc = array_shift($objsMbqEtPc);
            $oMbqRdEtPcMsg = MbqMain::$oClk->newObj('MbqRdEtPcMsg');
            if ($objsMbqEtPcMsg = $oMbqRdEtPcMsg->getObjsMbqEtPcMsg(array($msgId), array('case' => 'byMsgIds'))) {
                $oMbqEtPcMsg = array_shift($objsMbqEtPcMsg);
                $oMbqAclEtPcMsg = MbqMain::$oClk->newObj('MbqAclEtPcMsg');
                if ($oMbqAclEtPcMsg->canAclGetQuoteConversation($oMbqEtPcMsg, $oMbqEtPc)) {
                    $this->data['text_body'] = (string) $oMbqRdEtPcMsg->getQuoteConversation($oMbqEtPcMsg);
                } else {
                    MbqError::alert('', '', '', MBQ_ERR_APP);
                }
            } else {
                MbqError::alert('', "Need valid conversation message id!", '', MBQ_ERR_APP);
            }
        } else {
            MbqError::alert('', "Need valid conversation id!", '', MBQ_ERR_APP);
        }
    }
  
}

?>