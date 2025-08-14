<?php

class AutomationScriptParser {
    private $script;
    private $tokens;
    private $parsedScript;

    public function __construct($script) {
        $this->script = $script;
        $this->tokens = array();
        $this->parsedScript = array();
    }

    public function parse() {
        $this->tokenize();
        $this->parseTokens();
        return $this->parsedScript;
    }

    private function tokenize() {
        $script = preg_replace('/\s+/', ' ', $this->script);
        $this->tokens = explode(' ', $script);
    }

    private function parseTokens() {
        foreach ($this->tokens as $token) {
            switch ($token) {
                case 'WAIT':
                    $this->parsedScript[] = array('action' => 'wait', 'duration' => $this->getDuration());
                    break;
                case 'CLICK':
                    $this->parsedScript[] = array('action' => 'click', 'element' => $this->getElement());
                    break;
                case 'TYPE':
                    $this->parsedScript[] = array('action' => 'type', 'text' => $this->getText());
                    break;
                default:
                    throw new Exception("Unknown token: $token");
            }
        }
    }

    private function getDuration() {
        // assume the next token is the duration
        return $this->tokens[++$i];
    }

    private function getElement() {
        // assume the next token is the element
        return $this->tokens[++$i];
    }

    private function getText() {
        // assume the next token is the text
        return $this->tokens[++$i];
    }
}

// Test case
$script = "WAIT 5 CLICK button TYPE hello world";
$parser = new AutomationScriptParser($script);
$parsedScript = $parser->parse();

print_r($parsedScript);

?>