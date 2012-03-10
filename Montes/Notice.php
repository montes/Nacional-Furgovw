<?php
/*
 * This is an UTF-8 file
 * 
 * This file is part of the montes utility library
 * 
 * (C) Javier Montes <kalimocho@gmail.com> 
 *
 * Twitter: @mooontes
 * Web: http://mooontes.com
 * 
 * "Montes Library" is licensed under GPL 2.0 
 * http://www.gnu.org/licenses/gpl-2.0.html
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * 
 */

namespace Montes;

class Notice
{

    public static function catchException($e)
    {
        echo '<h1>'.$e->message().'</h1>';
    }
}
?>
