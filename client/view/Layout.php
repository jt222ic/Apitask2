
<?php


class Layout
{
    
    function render($CollectionView)
    {
        
        echo 
        
        '
        <html>
        <head>
        
        </head>
        
        <body>
        <p> hejj<p>
        
        <div>'.$CollectionView->renderPage().'<div>
        </body>
        
        </html>
        
        ';
        
        
        
        
    }
    
    
    
}