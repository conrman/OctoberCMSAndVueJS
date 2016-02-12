<?php namespace SublimeArts\DealerStore\Updates;

use Seeder;
use SublimeArts\DealerStore\Models\Product;

class SeedUsersTable extends Seeder
{
    public function run()
    {
        $product = Product::create([
            'name'          => 'Mojo',
            'code'          => 'mojo',
            'tagline'       => 'USB MIDI Foot Controller',
            'description'   => '
                <ul>
                    <li>USB based Midi Controller that works on any cross platform like MACOSX, Windows & Linux without additional drivers or software installation.</li>
                    <li>Hands free control over your favourite DAWs to control the parameters.</li>
                    <li>Control the stomp boxes and patches of your DAW like real pedals.</li>
                    <li>Works with your favourite softwares like Abelton Live, Logic, Guitar Rig, Cubase, Nuendo etc.</li>
                    <li>Rigid metal construction and stomp switches.</li>
                    <li>USB powered and does not require additional power supply.</li>
                    <li>Does not alter any audio signal.</li>
                    <li>Take your favourite DAW for LIVE playing!</li>
                    <li>Controls pedals and effects on your computer or mac.</li>
                    <li>Ideal for all musicians (Guitars, Bass, Vocals, Keyboard players and anyone who uses MIDI)</li>
                    <li>Easy programming no additional software needed.</li>
                    <li>Extra Expression pedal input allows to feed in standard expression pedal (like Roland etc) and convert it to USB expression pedal.</li>
                </ul>
            ',
            'fob_price'     => 200,
            'dealer_price'  => 300,
            'retail_price'  => 500,
            'is_activated'  => true
        ]);
        
        $product = Product::create([
            'name'          => 'VX1',
            'code'          => 'vx1',
            'tagline'       => 'USB Based Expression Pedal',
            'description'   => '
                <ul>
                    <li>Plug and play expression pedal for computers and Mac.</li>
                    <li>Works with Mac, Windows and Linux.</li>
                    <li>Does not alter any audio signal.</li>
                    <li>Assign your favourite effects like Wah, Volume, Pitch shifter, Envelope filter effects etc.</li>
                    <li>Easy to assign parameter control.</li>
                    <li>Works with Logic, Abelton Live, Guitar Rig, Cubase etc</li>
                    <li>One pedal assignable to multiple expressions through your DAW.</li>
                    <li>Ideal for all musicians (Guitars, Bass, Vocals, Keyboard players and anyone who uses MIDI)</li>
                    <li>Easy Midi assignment capability.</li>
                </ul>
            ',
            'fob_price'     => 150,
            'dealer_price'  => 250,
            'retail_price'  => 450,
            'is_activated'  => true
        ]);
       
        $product = Product::create([
            'name'          => 'Dynamo Pro',
            'code'          => 'dynamo-pro',
            'tagline'       => 'Analog Linear Power Supply',
            'description'   => '
                <ul>
                    <li>Fully analog regulated multi output rail power supply for pedals.</li>
                    <li>Toroidal transformer with ground shield for chassis.</li>
                    <li>4 True Isolated Rails with total of 11 DC power outlets.</li>
                    <li>Noiseless performance.</li>
                    <li>Individual dedicated regulators for each rail.</li>
                    <li>Fuse protection circuit to protect your expensive gear.</li>
                    <li>All the 4 rails have an LED indicator indicating any shortage in your pedals.</li>
                    <li>User changeable fuse operation for easy replacement if needed.</li>
                    <li>1st rail consists of 4 9V DC power outlets with total power of 500mA</li>
                    <li>2nd rail consists of 4 9V DC power outlets with total power of 500mA</li>
                    <li>3rd rail consists of 2 9V DC power outlets with total power of 500mA</li>
                    <li>4th rail consists of 1 Variable Power outlet of 500mA letting you choose between SAG mode, 9VDC or 12VDC.</li>
                    <li>Length 11.4”, Width 4.5” and Height 1.96” (All measurements are in inches)</li>
                </ul>
            ',
            'fob_price'     => 200,
            'dealer_price'  => 250,
            'retail_price'  => 350,
            'is_activated'  => true
        ]);
       
        $product = Product::create([
            'name'          => 'Dynamo',
            'code'          => 'dynamo',
            'tagline'       => 'Analog Linear power Supply',
            'description'   => '
                <ul>
                    <li>Fully analog regulated multi output rail power supply for pedals.</li>
                    <li>Toroidal transformer with ground shield for chassis.</li>
                    <li>2 True Isolated Rails with total of 8 DC power outlets.</li>
                    <li>Noiseless performance.</li>
                    <li>Individual dedicated regulators for each rail.</li>
                    <li>Fuse protection circuit to protect your expensive gears.</li>
                    <li>Both the rails have an LED indicator indicating any shortage in your pedals.</li>
                    <li>User changeable fuse operation for easy replacement if needed.</li>
                    <li>1st rail consists of 4 9V DC power outlets with total power of 500mA.</li>
                    <li>2nd rail consists of 4 9V DC power outlets with total power of 500mA.</li>
                    <li>Length 7.8”, Width 4.5” and Height 1.96” (All measurements are in inches).</li>
                </ul>
            ',
            'fob_price'     => 150,
            'dealer_price'  => 200,
            'retail_price'  => 250,
            'is_activated'  => true
        ]);
    }
}